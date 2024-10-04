<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Commission;
use App\Models\User;
use App\Models\UserAddress;
use Bavix\Wallet\Models\Transaction;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Intervention\Image\Point;
use Razorpay\Api\Order;
use Session;
use App\Models\Cart;
use App\Models\OrdersModel;
use App\Models\OrderDetails;
use App\Models\DeliverAddress;
use App\Models\Points;
use App\Models\ComissionModel;
use App\Models\TransferCommission;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SaveAppliedDiscount;
use Razorpay\Api\Api;
class CheckoutController extends Controller
{
    function getUserIP()
    {
        // Get real visitor IP behind CloudFlare network
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }

        return $ip;
    }

    function cart(){
        if(Auth::check()){
            $userid = Auth::user()->id;
            $data['title'] = 'Home';
            $data['cart'] = Cart::select('carts.*',
                'product_size_attributes.size as sizeName',
                'product_size_attributes.msp as productMspFromsizeAttr',
                'product_size_attributes.flash_price as flash_price',
                'product_size_attributes.discount_pecent as discount_pecent',
                'product_size_attributes.qty as productInventoryFromSizeAttr',
                'product_size_attributes.price as productSizePrice',
                'product_size_attributes.qty as productSizeqty'
            )
                ->leftJoin("product_size_attributes",'carts.size','product_size_attributes.id')
                ->where('carts.status','yes')
                ->where('carts.ip_address',$_SERVER['REMOTE_ADDR'])
                ->orWhere('carts.user_id',$userid)
                ->with(['getProducts','getBrands','getSections'])
                ->get();

            $data['cart_count'] = $data['cart']->count();
            $data['cart_price'] = $data['cart']->sum('subtotal');
            $data['cart_msp'] = $data['cart']->sum('msp');
            $data['sumof_msp'] = '';


            foreach($data['cart'] as $cartData){
                $data['sumof_msp'] = $cartData->sum('sumofmsp');
                $data['discountonmrp'] = $data['sumof_msp'] - $cartData->sum('subtotal');
            }

            $data['getCouponsaboveCartValue'] = Coupon::where('min_cart_value','>=',$data['cart_price'])->get();
            $data['getCouponsbelowCartValue'] = Coupon::where('min_cart_value','<=',$data['cart_price'])->get();


            if(Auth::check()){
                $userData = Auth::user()->id;
            }else{
                $userData = $_SERVER['REMOTE_ADDR'];
            }
            $data['getAppliedCoupon'] = '';
            if(Auth::check()){
                $userid = Auth::user()->id;
                $userIp = $this->getUserIP();
            }else{
                $userIp = $this->getUserIP();
            }
            $data['getAppliedCoupon'] = SaveAppliedDiscount::where([
                'ip_address' => $userIp,
                'userid' => $userid,
                'is_active' => 'yes',
                'is_used' => 'no',
            ])->first();

            if(!empty($data['getAppliedCoupon'])){
                $data['Appliedcoupons'] =
                    [
                        'coupon_Code' => $data['getAppliedCoupon']->coupon_code,
                        'coupon_discount_type' =>$data['getAppliedCoupon']->couponDiscountType,
                        'coupondiscount' =>$data['getAppliedCoupon']->coupon_discount_amount
                    ];
            }else{
                $data['Appliedcoupons'] =
                    [
                        'coupon_Code' => 0,
                        'coupon_discount_type' => 0,
                        'coupondiscount' => 0
                    ];
            }

            $getpoints = Points::select('points_credit','points_debit')->where('user_id',$userid)->get();
            $data['getpoints'] = $getpoints->sum('points_credit');



            return view('web.cart', $data);
        }else{
            return redirect('/login');
        }
    }

    function applied_discount_amount(Request $request){
        $sql = new SaveAppliedDiscount ;

        $couponDetails = [
            'couponCode' => $request->couponCode,
            'couponDiscountType' => $request->couponDiscountType,
            'coupondiscount' => $request->coupondiscount,
            'couponAmount' => $request->couponAmount,
        ];
        if(Auth::check()){
            $userid = Auth::user()->id;
            $userIp = $this->getUserIP();
        }else{
            $userIp = $this->getUserIP();
        }
        $sql->coupon_code = $request->couponCode;
        $sql->coupon_discount_amount = $request->couponAmount;
        $sql->couponDiscountType = $request->couponDiscountType;
        $sql->ip_address = $userIp;
        $sql->userid = $userid;
        $sql->is_active = 'yes';
        $sql->is_used = 'no';

        if($sql->save()){
            $getAppliedCoupon = SaveAppliedDiscount::where([
                'ip_address' => $userIp,
                'userid' => $userid,
                'is_active' => 'yes',
                'is_used' => 'no',
            ])->first();
            return response()->json(['code' => 200 ,
                'coupon_Code' => $couponDetails['couponCode'],
                'coupon_discount_amount' =>$couponDetails['coupondiscount'],
                'coupon_discount_type' =>$couponDetails['couponDiscountType'],
                'coupondiscount' =>$couponDetails['couponAmount']
            ]);
        }

    }

    function removeCoupon(){
        if(Auth::check()){
            $userData = Auth::user()->id;
        }else{
            $userData = $_SERVER['REMOTE_ADDR'];
        }

        $sql = SaveAppliedDiscount::where('ip_address',$userData)->delete();
        return redirect($_SERVER['HTTP_REFERER']);
    }

    function address(){
        if(Auth::check()){

            $data['title'] = 'Home';
            $userid = Auth::user()->id;

            $data['totalamount'] = base64_decode($_GET['totalamount']);
            $data['getpointsValue'] = $_GET['getpointsValue'];
            if(!empty($_GET['additional_coupon'])){
                $data['additionalcoupon'] = base64_decode($_GET['additional_coupon']);
            }else{
                $data['additionalcoupon'] = 0;
            }
            $data['coupon_discount_amount'] = base64_decode($_GET['coupon_discount_amount']);
            $data['couponDiscountType'] = base64_decode($_GET['couponDiscountType']);
            $data['coupon_code'] = base64_decode($_GET['coupon_code']);

            $data['cart'] = Cart::select('carts.*',
                'product_size_attributes.size as sizeName',
                'product_size_attributes.msp as productMspFromsizeAttr',
                'product_size_attributes.flash_price as flash_price',
                'product_size_attributes.discount_pecent as discount_pecent',
                'product_size_attributes.qty as productInventoryFromSizeAttr',
                'product_size_attributes.price as productSizePrice',
                'product_size_attributes.qty as productSizeqty'


            )
                ->leftJoin("product_size_attributes",'carts.size','product_size_attributes.id')
                ->where('carts.status','yes')
                ->where('carts.ip_address',$this->getUserIP())
                ->orWhere('carts.user_id',$userid)
                ->with(['getProducts','getBrands','getSections'])
                ->get();

            $data['cart_count'] = $data['cart']->count();
            $data['cart_price'] = $data['cart']->sum('subtotal');
            $data['cart_msp'] = $data['cart']->sum('msp');
            $data['sumof_msp'] = '';


            foreach($data['cart'] as $cartData){
                $data['sumof_msp'] = $cartData->sum('sumofmsp');
                $data['discountonmrp'] = $data['sumof_msp'] - $cartData->sum('subtotal');
            }

            $data['getCouponsaboveCartValue'] = Coupon::where('min_cart_value','>=',$data['cart_price'])->get();
            $data['getCouponsbelowCartValue'] = Coupon::where('min_cart_value','<=',$data['cart_price'])->get();


            if(Auth::check()){
                $userid = Auth::user()->id;
                $userIp = $this->getUserIP();
            }else{
                $userIp = $this->getUserIP();
            }
            $data['getAppliedCoupon'] = '';
            $getAppliedCoupon = SaveAppliedDiscount::where([
                'ip_address' => $userIp,
                'userid' => $userid,
                'is_active' => 'yes',
                'is_used' => 'no',
            ])->first();

            $data['deliveryAddress'] = DeliverAddress::where('addedby',Auth::user()->id)->get();

            return view('web.address', $data);
        }else{
            return redirect('/login');
        }

    }

    function saveaddress(Request $request){
        $sql = new DeliverAddress;
        $sql->name = $request->name;
        $sql->mobile = $request->mobile;
        $sql->address_one = $request->address_one;
        $sql->address_two = $request->address_two;
        $sql->pincode = $request->pincode;
        $sql->city = $request->city;
        $sql->state = $request->state;
        $sql->landmark = $request->landmark;
        $sql->address_type = $request->addresstype;
        $sql->is_default_address = $request->is_default;
        $sql->addedby = Auth::user()->id;
        $sql->user_email = Auth::user()->email;
        if($sql->save()){
            return response()->json(['code'=>200]);
        }
    }

    function updateAddress(Request $request){
        if(!Auth::check()){
            return redirect(route("frontendlogin"));
        }
        $sql = DeliverAddress::find($request->addressid);

        $sql->name = $request->name;
        $sql->mobile = $request->mobile;
        $sql->address_one = $request->address_one;
        $sql->address_two = $request->address_two;
        $sql->pincode = $request->pincode;
        $sql->city = $request->city;
        $sql->state = $request->state;
        $sql->landmark = $request->landmark;
        $sql->address_type = $request->addressType;
        $sql->is_default_address = $request->is_default;
        $sql->addedby = Auth::user()->id;
        $sql->user_email = Auth::user()->email;
        if($sql->save()){
            return response()->json(['code'=>200]);
        }
    }

    function userdashboardsave_address(Request $request)
    {
        // Check if the save_address checkbox is checked
        if (auth()->check()) {
            // Save the address to the user's profile
            $userAddress = new UserAddress();
            $userAddress->user_id = auth()->user()->id;
            $userAddress->first_name = $request->input('first_name');
            $userAddress->last_name = $request->input('last_name');
            $userAddress->company_name = $request->input('company_name');
            $userAddress->country = $request->input('country');
            $userAddress->address_1 = $request->input('address_1');
            $userAddress->address_2 = $request->input('address_2');
            $userAddress->city = $request->input('city');
            $userAddress->state = $request->input('state');
            $userAddress->pincode = $request->input('pincode');
            $userAddress->phone = $request->input('phone');
            $userAddress->email = $request->input('email');

            $userAddress->save();

            // If the request was made via AJAX, return a JSON response
            if ($request->ajax()) {
                // Return a response
                return response()->json([
                    'first_name' => $userAddress->first_name,
                    'last_name' => $userAddress->last_name,
                    'company_name' => $userAddress->company_name,
                    'country' => $userAddress->country,
                    'address_1' => $userAddress->address_1,
                    'address_2' => $userAddress->address_2,
                    'city' => $userAddress->city,
                    'state' => $userAddress->state,
                    'pincode' => $userAddress->pincode,
                    'phone' => $userAddress->phone,
                    'email' => $userAddress->email,
                    // ... other fields ...
                ]);
            }

            // If the request was not made via AJAX, redirect back
            return redirect()->back();
        }
    }

    function save_address(Request $request){


        Session::put('user_address',$request->all());

        // Check if the save_address checkbox is checked
        if (auth()->check()) {
            // Save the address to the user's profile
            $userAddress = new UserAddress();
            $userAddress->user_id = auth()->user()->id;
            $userAddress->first_name = $request->input('first_name');
            $userAddress->last_name = $request->input('last_name');
            $userAddress->company_name = $request->input('company_name');
            $userAddress->country = $request->input('country');
            $userAddress->address_1 = $request->input('address_1');
            $userAddress->address_2 = $request->input('address_2');
            $userAddress->city = $request->input('city');
            $userAddress->state = $request->input('state');
            $userAddress->pincode = $request->input('pincode');
            $userAddress->phone = $request->input('phone');
            $userAddress->email = $request->input('email');

            $userAddress->save();
            return redirect($_SERVER['HTTP_REFERER']);
        }

    }

    function update_address(Request $request){

        // Check if the save_address checkbox is checked
        if (auth()->check()) {
            // Save the address to the user's profile
            $userAddress = UserAddress::find($request->address_id);
            $userAddress->user_id = auth()->user()->id;
            $userAddress->first_name = $request->input('first_name');
            $userAddress->last_name = $request->input('last_name');
            $userAddress->company_name = $request->input('company_name');
            $userAddress->country = $request->input('country');
            $userAddress->address_1 = $request->input('address_1');
            $userAddress->address_2 = $request->input('address_2');
            $userAddress->city = $request->input('city');
            $userAddress->state = $request->input('state');
            $userAddress->pincode = $request->input('pincode');
            $userAddress->phone = $request->input('phone');
            $userAddress->email = $request->input('email');

            $userAddress->save();
            return redirect($_SERVER['HTTP_REFERER']);
        }

    }

    function remove_address($id){
        $sql = UserAddress::where('id',$id)->delete();
        return redirect($_SERVER['HTTP_REFERER']);

    }

    public function checkout_submit(Request $request)
    {
//        print_r($request->all());die;

       $name =  $request->first_name .' '.$request->last_name;
        if($request->create_account == 'yes'){
            $name = $request->first_name .' '.$request->last_name;
            $email = $request->email;
            $phone = $request->phone;
            $password = $request->phone;

            $checkUser = User::where('email',$email)->count();
            if($checkUser == 0){
                $user = new User();

                $user->name = $name;
                $user->email = $email;
                $user->password = Hash::make($password);
                $user->salt_password = $password;
                $user->mobile_number = $phone;
                $user->role = '2';
                $user->status = '0';


                $email;
                $userpassword = $password;
//                print_r($email);die;

                \Mail::send('emails.usercredentials',compact('email','userpassword'), function($message) use($request){
                    $message->to($request->input('email')); // Use $request to get the email
                    $message->subject('Email Verification Mail');
                });



                $token = \Str::random(64);

                $user->save();

//                $emailVerification = new \App\Models\UserVerify;
////            $emailVerification->userid	 = $user->id;
//                $emailVerification->userid	 =  $user->id;
//                $emailVerification->token = $token;
//                $emailVerification->status = 0;
//                $emailVerification->save();

                $email = $user->email;
                $data1['created_at'] = $user->email;
                $senderid = 'Groovv';
                $sendto = $phone;
                $message = "Hurray! You're truly special to us. Make your own statement with India's leading audio brand -Grooves . For special discounts, visit www.grooveslifestyle.com";
                $templateid = '1707170453825822776';

                $username = 'grooves';
                $password = '887200';
                $senderId = $senderid;
                $sendTo = $sendto; // Replace with the actual phone number
                $message = $message;
                $PEID = '';
                $templateId = $templateid;

// Build the API URL
                $apiUrl = "http://45.249.108.134/api.php";

// Set up the curl request
                $ch = curl_init($apiUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, [
                    'username' => $username,
                    'password' => $password,
                    'sender' => $senderId,
                    'sendto' => $sendTo,
                    'message' => $message,
                    'PEID' => $PEID,
                    'templateid' => $templateId,
                ]);

// Execute the request
                $response = curl_exec($ch);

// Close the curl session
                curl_close($ch);

// Process the response as needed
                echo $response;


//            print_r($email);die;
//            \Mail::send('emails.UserVerification',['token' => $token] , function($message) use($request){
//                $message->to($request->input('email')); // Use $request to get the email
//                $message->subject('Email Verification Mail');
//            });

//                Auth::login($user);


            }
        }

        if($request->same_billing){
            $same_billing = '1';
        }else{
            $same_billing = '0';
        }

        if($request->final_amount == 'NaN'){
            Session::flash('error','Please check your zipcode');
            return Redirect::back()->with('error','Please check your zipcode');
        }

        Session::put('products_details',$request->all());


        if(isset($request->shipping_price)){
            $removedollar = ltrim($request->shipping_price, $request->shipping_price[0]);
            Session::put('shpping_rates',$removedollar);
        }

        // Check if the save_address checkbox is checked
        if ($request->has('save_address') && auth()->check()) {
            // Save the address to the user's profile
//
//            echo "inside";
//            die;
            $userAddress = new UserAddress();
            $userAddress->user_id = auth()->user()->id;
            $userAddress->first_name = $request->input('first_name');
            $userAddress->last_name = $request->input('last_name');
            $userAddress->company_name = $request->input('company_name');
            $userAddress->country = 'India';
            $userAddress->address_1 = $request->input('address_1');
            $userAddress->address_2 = $request->input('address_2');
            $userAddress->city = $request->input('city');
            $userAddress->state = $request->input('state');
            $userAddress->pincode = $request->input('pincode');
            $userAddress->phone = $request->input('phone');
            $userAddress->email = $request->input('email');

            $userAddress->save();
        }

//        die;
        $order_id = rand(111,999).rand(999,222).rand(111,999);
        $api = new Api("rzp_test_qhoHxWm9KDHv1C", "eCyRe3qA5z1SRy9bSJpx9TfD");

        $razororder = $api->order->create([
            'receipt'         => $order_id,
            'amount'          => 10 * 100, // Amount in paisa
            'currency'        => 'INR',
            'payment_capture' => 1 // Auto capture payment
        ]);

        $order = \App\Models\Order::create([
            'order_id' => $order_id,
            'razororder_id' => $razororder->id,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_id' => Auth::user()->id ?? '',
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'country' => 'India',
            'address_1' => $request->input('address_1'),
            'address_2' => $request->input('address_2'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'pincode' => $request->input('pincode'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'final_amount' => $request->input('final_amount'),
            'coupon_code' => $request->input('coupon_code'),
//            'sales_tax' => $request->input('sales_tax'),

            'same_billing' => $same_billing ,
            'billing_first_name' => $same_billing == '0' ? $request->billing_first_name : $request->input('first_name') ,
            'billing_last_name' => $same_billing == '0' ? $request->billing_last_name :  $request->input('last_name'),
            'billing_country' => $same_billing == '0' ? $request->billing_country : $request->input('country'),
            'billing_address_1' => $same_billing == '0' ? $request->billing_address_1 : $request->input('address_1'),
            'billing_address_2' => $same_billing == '0' ? $request->billing_address_2 : $request->input('address_2'),
            'billing_city' => $same_billing == '0' ? $request->billing_city : $request->input('city'),
            'billing_state' => $same_billing == '0' ? $request->billing_state : $request->input('state'),
            'billing_pincode' => $same_billing == '0' ? $request->billing_pincode : $request->input('pincode'),
            'billing_phone' => $same_billing == '0' ? $request->billing_phone : $request->input('phone'),
            'billing_email' => $same_billing == '0' ? $request->billing_email : $request->input('email'),
            'selected_courier' => $request->final_amount,
//            'shipping_price' => $request->input('shipping_price'),
            'status' => $request->payment_mode == 'cod' ? '1' : '0',
        ]);

//        die;
        Session::put('order_details',$order);


//        print_r($request->all());die;
        $productIds = $request->input('product_id');
//        $attributeIds = $request->input('attribute_id');
        $quantities = $request->input('qty');
        $color = $request->product_color ?? '0';
//        print_r($color);die;
        $prices = $request->input('price');
//        $sizes = $request->input('size');
        $phone = $request->phone;

        if (
            $productIds && $quantities && $prices  &&
            count($productIds) === count($quantities) &&
            count($productIds) === count($prices)
        ) {
            for ($i = 0; $i < count($productIds); $i++) {
                $order->products()->attach(
                    $productIds[$i],
                    [
                        'quantity' => $quantities[$i],
                        'price' => $prices[$i],
//                        'color' => $color[$i],
                    ]
                );
            }
        }
        if(Session::has('order_details')){
            $getOrderSession = Session::get('order_details');
        }

//        print_r($getOrderSession);die;

        $productDetails = [];

        for ($i = 0; $i < count($request->product_name); $i++) {
            $productDetails[] = [
                'name' => $request->product_name[$i],
                'sku_number' => $request->product_id[$i], // Assuming product_id is the SKU number
                'quantity' => $request->qty[$i],
                'discount' => '', // You may want to add the discount logic here
                'unit_price' => $request->price[$i],
                'product_category' => 'Other', // Replace with the actual product category
            ];
        }

        Session::put('productDetailsArray',$productDetails);

        if($request->payment_mode == 'cod'){

            $message = "Hi ".$name." , Thanks for placing your order with us. Your Order tracking Id is - ".$order_id." Track your order on - Grooveslifestyle.com";
            $templateId = '1707170454029388175';

            $username = 'grooves';
            $password = '887200';
            $sendTo = $phone; // Replace with the actual phone number
            $message = $message;
            $templateId = $templateId;

//              $response = sendSMS( 'username', 'password','senderid','sendto','message','template id' )
            $response = $this->sendSMS($username, $password, 'Groovv', $sendTo, $message, '1707170454029388175');


            // Extract data from the $order model instance
            $apiData = [
                'order_id' => $order->order_id,
                'order_date' => $order->created_at->toDateString(), // Assuming created_at is the order date
                'order_type' => 'ESSENTIALS', // Replace with the actual order type
                'consignee_name' => utf8_encode($order->first_name),
//                'consignee_phone' => $order->phone,
                'consignee_phone' =>'9876543210',
                'consignee_email' => $order->email,
                'consignee_address_line_one' => $order->address_1,
                'consignee_address_line_two' => $order->address_2,
                'consignee_pin_code' => $order->pincode,
                'consignee_city' => $order->city,
                'consignee_state' => $order->state,
                'product_detail' => $productDetails,

                'payment_type' => 'PREPAID', // Replace with the actual payment type
                'cod_amount' => '', // Replace with the actual COD amount
                'weight' => 200, // Replace with the actual weight
                'length' => 10, // Replace with the actual length
                'width' => 20, // Replace with the actual width
                'height' => 15, // Replace with the actual height

                'warehouse_id' => '', // Replace with the actual warehouse ID
                'gst_ewaybill_number' => '', // Replace with the actual GST e-waybill number
                'gstin_number' => '', // Replace with the actual GSTIN number
                'order_primary_id' => $order->id
            ];
            $response = sendOrderRequest($apiData);


            $order->status = '1';

            if($order->save()){

                $buyermail = $request->email;
                \Mail::send('emails.order-confirmation', $apiData , function($message) use($request){
                    $message->to($request->email); // Use $request to get the email
                    $message->cc('shivekbindra@gmail.com'); // Use $request to get the email
                    $message->subject('Order Confirmation');
                });
                $removeCart = Cart::where('ip_address',$_SERVER['REMOTE_ADDR'])->delete();
//                die;
                return Redirect::to('view-orders-details/'.$order->id)
                    ->with('order_placed','Order has been placed. We will notify your Tracking Id on email');

            }


        }else{

            if(!empty($getOrderSession)){
                // Store the required data in the state parameter
                $stateData = array(
                    'price' => 1000,
                    'package_id' => $getOrderSession->id,
                    'order_id' => $getOrderSession->order_id,
                    'totalAmount' =>  1000,
                    'username' => $request->name,
                    'useremail' => $request->email,
                    'contact' => $request->phone,
                    'userid' => 1,
                );
            }

//            print_r($order);die;

            return redirect(url('redirect-to-pay/'.$razororder->id));

        }

    }

    function redirecTopay($id) {
        $orderid = $id;

        // Pass the order ID to the view as an associative array
        return view('web.razorpay-payment', ['orderid' => $orderid]);
    }

    public function paymentSuccess(Request $request)
    {
        $input = $request->all();

        // Initialize the Razorpay API instance
        $api = new Api('rzp_test_qhoHxWm9KDHv1C', 'eCyRe3qA5z1SRy9bSJpx9TfD');

        // Fetch the payment details using Razorpay payment ID
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
        if($payment->status == 'captured'){
            $status = 1;
        }
        $razororderid = $payment->order_id;
        $getOrder = \App\Models\Order::where('razororder_id',$razororderid)->first();
        $getOrder->payment_intent_id = $payment->id;
        $getOrder->status = $status;
//        $getOrder->complete_response = $payment;

//        print_r($payment->status);die;
        // Check if the payment status is 'captured'
        if ($getOrder->save()) {
//            echo "as";
            // Payment was successful, handle success (e.g., update order status)
            return redirect(url('order-complete/'.$getOrder->razororder_id))->with('success', 'Payment successful!');

        } else {
//            echo "Ds";
            // Payment was not successful, handle failure
            return redirect()->back()->with('error', 'Payment failed!');
        }
    }



    function phonepe_callback(Request $request){

        $data = $request->all();
        if(Session::has("productDetailsArray")) {
            $productDetails = Session::get('productDetailsArray');
        }else{
            $productDetails = [];
        }
//        die;

        $getOrderData = json_decode($request->state);
//        print_r();die;

        $orderData = \App\Models\Order::where( 'order_id' , $getOrderData->order_id )->first();

        $orderData->payment_intent_id = $data['transactionId'];
        $orderData->payment_method = $data['providerReferenceId'] ?? '';
        $orderData->transaction_status = $data['code'];
        $orderData->complete_response  = $request->state;


        $order_primary_id = $orderData->id;
        if($data['code'] == 'PAYMENT_ERROR'){
            $orderData->status = '0';
        }

        if($data['code'] == 'PAYMENT_SUCCESS '){
            $orderData->status = '1';
        }


        if($orderData->save()){
            // Extract data from the $order model instance
            $apiData = [
                'order_id' => $orderData->order_id,
                'order_date' => $orderData->created_at->toDateString(), // Assuming created_at is the order date
                'order_type' => 'ESSENTIALS', // Replace with the actual order type

                //            'consignee_name' => $order->first_name . ' ' . $order->last_name,
                'consignee_name' => utf8_encode($orderData->first_name),
//                'consignee_phone' => $order->phone,
                'consignee_phone' => $orderData->phone,
                'consignee_email' => $orderData->email,
                'consignee_address_line_one' => $orderData->address_1,
                'consignee_address_line_two' => $orderData->address_2,
                'consignee_pin_code' => $orderData->pincode,
                'consignee_city' => $orderData->city,
                'consignee_state' => $orderData->state,
                'product_detail' => $productDetails,

                'payment_type' => 'PREPAID', // Replace with the actual payment type
                'cod_amount' => '', // Replace with the actual COD amount
                'weight' => 200, // Replace with the actual weight
                'length' => 10, // Replace with the actual length
                'width' => 20, // Replace with the actual width
                'height' => 15, // Replace with the actual height

                'warehouse_id' => '', // Replace with the actual warehouse ID
                'gst_ewaybill_number' => '', // Replace with the actual GST e-waybill number
                'gstin_number' => '', // Replace with the actual GSTIN number
            ];


            $response = sendOrderRequest($apiData);

            $apiData['order_primary_id'] = $order_primary_id;

            $removeCart = Cart::where('ip_address',$_SERVER['REMOTE_ADDR'])->delete();

            $getOrderSession = Session::get('order_details');
            $orderid = $getOrderSession->order_id ?? $getOrderData->order_id ;
            $name = $getOrderSession->first_name ?? 'User';
            $phone = $getOrderData->contact;

            Session::forget('getAllCartSession');
            Session::flash('order_placed','Order has been placed. We will notify your Tracking Id on email');

            $buyermail = $getOrderData->useremail;


            if($data['code'] == 'PAYMENT_SUCCESS'){

                $message = "Hi ".$name." , Thanks for placing your order with us. Your Order tracking Id is - ".$orderid." Track your order on - Grooveslifestyle.com";
                $templateId = '1707170454029388175';

                $username = 'grooves';
                $password = '887200';
                $sendTo = $phone; // Replace with the actual phone number
                $message = $message;
                $templateId = $templateId;
                $response = $this->sendSMS($username, $password, 'Groovv', $sendTo, $message, '1707170454029388175');


                \Mail::send('emails.order-confirmation', $apiData , function($message) use ($buyermail) {
                    $message->to($buyermail);
                    $message->subject('Order Confirmation');
                });

            }else{
                \Mail::send('emails.order-error', $apiData , function($message) use ($buyermail) {
                    $message->to($buyermail);
                    $message->subject('Order Not Confirmed');
                });
            }

//            die;
            return Redirect::to('view-orders-details/'.$orderData->id)
                ->with('order_placed','Order has been placed. We will notify your Tracking Id on email');

        }



    }

    function sendSMS($username, $password, $senderId, $sendTo, $message, $templateId, $PEID = '') {
        $apiUrl = "http://45.249.108.134/api.php";

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'username' => $username,
            'password' => $password,
            'sender' => $senderId,
            'sendto' => $sendTo,
            'message' => $message,
            'PEID' => '',
            'templateid' => $templateId,
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
    function payment_success(){
        return view('web.thankyou');
    }

    function get_shipping_details(Request $request){

//        print_r($request->all());die;

        $data = array(
            "origin_address" => array(
                "line_1" => "9 N Fordham Rd",
                "state" => "New York",
                "postal_code" => "11801",
                "city" => "Hicksville",
                "company_name" => "Long island Fragrances",
                "contact_name" => "Long island Fragrances",
                "contact_phone" => "5168141663",
                "contact_email" => "lifragrancesny@gmail.com"
            ),
            "destination_address" => array(
                "line_1" => "192 Spadina Ave",
                "state" => "Texas",
                "postal_code" => $request->pincode,
                "city" => "Flower Mound",
                "country_alpha2" => "CA",
                "company_name" => "Test",
                "contact_name" => "Test ",
                "contact_phone" => "7574884",
                "contact_email" => "test@gmail.com"
            ),
            "incoterms" => "DDU",
            "insurance" => array(
                "is_insured" => false
            ),
            "courier_selection" => array(
                "apply_shipping_rules" => true
            ),
            "shipping_settings" => array(
                "units" => array(
                    "weight" => "lb",
                    "dimensions" => "cm"
                )
            ),
            "parcels" => array(
                array(
                    "total_actual_weight" => "1",
                    "box" => array(
                        "slug" => "null",
                        "length" => $request->sum_length,
                        "width" =>  $request->sum_width,
                        "height" =>  $request->sum_height
                    ),
                    "items" => array(
                        array(
                            "quantity" => "1",
                            "dimensions" => array(
                                "length" => $request->sum_length,
                                "width" =>  $request->sum_width,
                                "height" =>  $request->sum_height
                            ),
                            "category" => "health_beauty",
                            "description" => "This is a nice product",
                            "sku" => "PRD-123",
                            "actual_weight" => "5",
                            "declared_currency" => "USD",
                            "declared_customs_value" => 1
                        )
                    )
                )
            )
        );

        $response = \Http::withHeaders([
            "Content-Type" => "application/json",
            "Authorization" => "Bearer prod_Et5YFzWn5FA3co/3ddpC33pzqgjnzjM9CXUtTkPgbCM="
        ])->post("https://api.easyship.com/2023-01/rates", $data);

//        Session::put('shipping_')

        return response()->json(json_decode($response->body()));
    }

    public function calculateTax(Request $request)
    {
        Stripe\Stripe::setApiKey('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');

        $stripe = new \Stripe\StripeClient('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');

        $response = $stripe->tax->calculations->create([
            'currency' => 'usd',
            'line_items' => [
                [
                    'amount' => 1000,
                    'reference' => 'L1',
                ],
            ],
            'customer_details' => [
                'address' => [
                    'line1' => '920 5th Ave',
                    'city' => 'Seattle',
                    'state' => 'WA',
                    'postal_code' => $request->input('postal_code'),
                    'country' => 'US',
                ],
                'address_source' => 'shipping',
            ],
            'expand' => ['line_items.data.tax_breakdown'],
        ]);

        $taxAmount = $response->line_items->data[0]->tax_amount;

        return response()->json([
            'taxAmount' => $taxAmount,
            'totalAmount' => 1000 + $taxAmount, // Adjust this as needed based on your product total
        ]);
    }
}
