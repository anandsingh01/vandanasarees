<?php

namespace App\Http\Controllers;

use App\Models\DeliverAddress;
use App\Models\Offer;
use App\Models\UserAddress;
use Auth;
use App\Models\WishlistModel;
use App\Models\Cart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

//    public function addToCart(Request $request)
//    {
//        $product_id = $request->product_id;
//        $size = $request->size;
//        $user_ip = $_SERVER['REMOTE_ADDR'];
//        $isUserAuthenticated = Auth::check();
//
////        print_r(Auth::id());die;
//        // Check if the product already exists in the cart
//        $existingCart = Cart::where(function ($query) use ($user_ip) {
//            $query->where('user_id', Auth::id())
//                ->orWhere('ip_address', $user_ip);
//        })
//            ->where('ip_address',$user_ip)
//            ->where('product_id', $product_id)
//            ->where('size', $size)
//            ->where('status', 'yes')
//            ->first();
////        print_r($existingCart);die;
//
//        if (!$existingCart) {
//            // Create a new cart item
//            $cart = new Cart;
//            $cart->product_added_by = $request->product_added_by;
//            $cart->product_id = $product_id;
//            $cart->product_name = $request->product_name;
//            $cart->brands_id = $request->brands_id;
//            $cart->section_id = $request->section_id;
//            $cart->price = $request->price;
//            $cart->subtotal = $request->subtotal;
//            $cart->msp = $request->msp;
//            $cart->sumofmsp = $request->msp * $request->cartqty;
//            $cart->size = $size;
//            $cart->cartqty = $request->quantity;
//            $cart->attribute_id = $request->attribute_id;
//            $cart->status = 'yes';
//
//            if ($isUserAuthenticated) {
//                $cart->user_id = Auth::user()->id;
//                $cart->ip_address = $user_ip;
//            } else {
//                $cart->user_id = null;
//                $cart->ip_address = $user_ip;
//            }
//
//            $cart->save();
//        } else {
//            // Update the existing cart item
//            $existingCart->cartqty += $request->quantity;
//            $existingCart->sumofmsp += $request->msp * $request->quantity;
//            $existingCart->subtotal += $request->subtotal * $request->quantity;
//            $existingCart->save();
//        }
//
////        print_r($user_ip);die;
//        // Calculate cart count and response data
//        if ($isUserAuthenticated) {
//            $cartCount = Cart::where('user_id', Auth::id())
//                ->where('ip_address', $user_ip)->count();
//        } else {
//            $cartCount = Cart::where('ip_address', $user_ip)->count();
//        }
//
//        $productsubtotal = Cart::where('product_id', $product_id)->select('subtotal')->first();
//        $qty = Cart::where('product_id', $product_id)->select('cartqty')->first();
//        $cartSubtotal = Cart::where('user_id', Auth::id())->sum('subtotal'); // Adjust this for IP-based carts
//
//        return response()->json([
//            'code' => $existingCart ? 301 : 200, // Status code 301 indicates a cart update
//            'cartCount' => $cartCount,
//            'subtotal' => $productsubtotal,
//            'qty' => $qty,
//            'cartSubtotal' => $cartSubtotal,
//            'status' => $existingCart ? 'Cart Updated' : 'Added to cart',
//        ]);
//    }

    function getAllCartsProducts(){


        $data['page_heading'] = 'Cart Page';
        if(Auth::check()){
            $data['getAllCart'] = \App\Models\Cart::where('user_id', Auth::id())
                ->with([
                    'getProducts', 'getBrands', 'getSection', 'getColor'
                ])
                ->get();
            $data['getsubtotal'] = $data['getAllCart']->sum('subtotal');

        }else{
            $data['getAllCart'] = \App\Models\Cart::where('ip_address', $_SERVER['REMOTE_ADDR'])
                ->with([
                    'getProducts', 'getBrands', 'getSection','getColor'
                ])
                ->get();
            $data['getsubtotal'] = $data['getAllCart']->sum('subtotal');
        }

//        print_r($data['getAllCart']);die;
        if ($data['getAllCart']->isEmpty()) {
            Session::flash('empty_cart','Please add items to cart');
//            echo "as";
            return redirect(url('/'));
        }

        if ($data['getAllCart']->isEmpty()) {
            // Remove the 'discounted_total' session if the cart is empty
            Session::forget('discounted_total');
        }

//        print_r($data['getsubtotal']);die;
        return view('web.cart', $data);
    }

    function addToCart(Request $request){
//        print_r($request->all());die;
        $sql = new Cart;
        $product_id = $request->product_id;
        $user_ip = $_SERVER['REMOTE_ADDR'];
//        print_r($user_ip);die;

        if(Auth::check()){
            // Auth User
            $cartDatas = Cart::where('user_id', Auth::id())
                ->where('product_id', $product_id)
                ->count();

            $getExistedCart = Cart::where('user_id', Auth::id())
                ->where('product_id', $product_id)
                ->first();

            if($cartDatas == 0)
            {
                $sql->user_id = Auth::user()->id;
                $sql->product_id = $product_id;
                $sql->product_added_by =  Auth::user()->id;
                $sql->ip_address =  $user_ip;
                $sql->product_id = $product_id;
                $sql->product_name = $request->product_name;
                $sql->price = $request->price * $request->quantity;
                $sql->per_piece_price = $request->price;
                $sql->subtotal = $request->price * $request->quantity;
                $sql->msp = $request->msp;
                $sql->sumofmsp = $request->msp * $request->quantity;
                $sql->cartqty = $request->quantity;
                $sql->color_id_attr = $request->color_id_attr;

                $sql->save();
                $cartCount = Cart::where('user_id',Auth::id())->count();
//                print_r($sql);die;

                $cartCount = Cart::where('ip_address',$user_ip)->count();
                $productsubtotal = Cart::where('ip_address',$user_ip)->where('product_id',$product_id)->select('subtotal')->first();
                $qty = Cart::where('ip_address',$user_ip)->where('product_id',$product_id)->select('cartqty')->first();
                $cartSubtotal = Cart::where('ip_address',$user_ip)->sum('subtotal');

                return response()->json(['code'=>200,
                    'cartCount' => $cartCount,
                    'subtotal' => $productsubtotal,
                    'qty' => $qty,
                    'cartSubtotal' => $cartSubtotal,
                    'status' => 'Added to cart'
                ]);
            }
            else
            {
                $getCartQtyOfProduct = Cart::where(['product_id' => $product_id])
                    ->where('attribute_id',$request->attribute_id)
                    ->where('user_id',Auth::id())
                    ->where('status', 'yes')
                    ->first();

                if($getCartQtyOfProduct->cartqty > 4){
                    return response()->json(['code'=> 429,
                        'status' => 'Cart Limit Exceed'
                    ]);
                }
//                print_r($getCartQtyOfProduct);
//                die;
                $updatePrice = $request->price * $request->quantity;
                $updatedCartQty = $getCartQtyOfProduct->cartqty + $request->quantity;

                $updatedCartPrice = $getCartQtyOfProduct->subtotal + $updatePrice;


                $updatingCart = Cart::where(['product_id' => $product_id])
                    ->where('user_id',Auth::id())
                    ->where('status', 'yes')
                    ->update([
                        'cartqty'=> $updatedCartQty,
                        'price'=>$updatedCartPrice,
                        'subtotal'=> $updatedCartPrice
                    ]);

                $cartCount = Cart::where('user_id',Auth::id())->count();
                $productsubtotal = Cart::where('user_id',Auth::id())
                    ->where('product_id',$product_id)->select('subtotal')->first();
                $qty = Cart::where('user_id',Auth::id())->where('product_id',$product_id)->select('cartqty')->first();
                $cartSubtotal = Cart::where('user_id',Auth::id())->sum('subtotal');

                return response()->json(['code'=>301,
                    'cartCount' => $cartCount,
                    'subtotal' => $productsubtotal,
                    'qty' => $qty,
                    'cartSubtotal' => $cartSubtotal,
                    'status' => 'Cart Updated'
                ]);
            }

        }else{
            // Guest User

            $cartDatas = Cart::where('ip_address', $user_ip)
                ->where('product_id', $product_id)
                ->count();


            $getExistedCart = Cart::where('ip_address', $user_ip)
                ->where('product_id', $product_id)
                ->first();

            $checkMaxQty = 3;

//            print_r($getExistedCart);die;
            if(!empty($getExistedCart)){
                if($getExistedCart->cartqty >= $checkMaxQty ){
                    return response()->json(['code'=> 429 ,'msg' => 'qty excced']);
                }
            }

            if($cartDatas == 0) {
                $sql->ip_address = $user_ip;
                $sql->product_id = $product_id;
                $sql->product_added_by = $request->product_added_by;
                $sql->product_id = $product_id;
                $sql->product_name = $request->product_name;
                $sql->brands_id = $request->brands_id;
                $sql->section_id = $request->section_id;
                $sql->price = $request->price * $request->quantity;
                $sql->per_piece_price = $request->price;

                $sql->subtotal =  $request->price * $request->quantity;
                $sql->msp = $request->msp;
                $sql->sumofmsp = $request->msp * $request->quantity;
                $sql->size = $request->size;
                $sql->cartqty = $request->quantity;
                $sql->attribute_id = $request->attribute_id;
                $sql->status = 'yes';
                $sql->color_id_attr = $request->color_id_attr;

//                    print_r($sql);die;

                $sql->save();
                $cartCount = Cart::where('user_id', Auth::id())->count();
                $productsubtotal = Cart::where('ip_address', $user_ip)->where('product_id', $product_id)->select('subtotal')->first();
                $qty = Cart::where('ip_address', $user_ip)->where('product_id', $product_id)->select('cartqty')->first();
                $cartSubtotal = Cart::where('ip_address', $user_ip)->sum('subtotal');

                return response()->json(['code' => 200,
                    'cartCount' => $cartCount,
                    'subtotal' => $productsubtotal,
                    'qty' => $qty,
                    'cartSubtotal' => $cartSubtotal,
                    'status' => 'Added to cart'
                ]);
            }
            else
            {

                $getCartQtyOfProduct = Cart::where(['product_id' => $product_id])
                    ->where('ip_address',$user_ip)
                    ->where('status', 'yes')
                    ->first();

                $updatePrice = $request->price * $request->quantity;
                $updatedCartQty = $getCartQtyOfProduct->cartqty + $request->quantity;

                $updatedCartPrice = $getCartQtyOfProduct->subtotal + $updatePrice;


                $updatingCart = Cart::where(['product_id' => $product_id])
                    ->where('ip_address',$user_ip)
                    ->where('status', 'yes')
                    ->update([
                        'cartqty'=> $updatedCartQty,
                        'price'=>$updatedCartPrice,
                        'subtotal'=> $updatedCartPrice
                    ]);

                $cartCount = Cart::where('ip_address',$user_ip)->count();
                $productsubtotal = Cart::where('ip_address',$user_ip)
                    ->where('product_id',$product_id)->select('subtotal')->first();
                $qty = Cart::where('ip_address',$user_ip)->where('product_id',$product_id)
                    ->select('cartqty')->first();
                $cartSubtotal = Cart::where('ip_address',$user_ip)->sum('subtotal');

                return response()->json(['code'=>301,
                    'cartCount' => $cartCount,
                    'subtotal' => $productsubtotal,
                    'qty' => $qty,
                    'cartSubtotal' => $cartSubtotal,
                    'status' => 'Cart Updated'
                ]);
            }
        }

    }

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







function delAllCartsProducts(){


        if(Auth::check()){
            $data['getAllCart'] = \App\Models\Cart::where('user_id', Auth::id())->delete();
        }else{
            $data['getAllCart'] = \App\Models\Cart::where('ip_address', $_SERVER['REMOTE_ADDR'])->delete();
        }
			 Session::flash('empty_cart','Please add items to cart');
			header('location:https://lifragrances.com/');



    }


















    function updateSizeCart(Request $request){

        $user_ip = $this->getUserIP();
        $sql = Cart::where('size', $request->size)
            ->where('product_id',$request->product_id)
            ->where('id','!=',$request->cart_id)
            ->count();
        if($sql > 0){

            $deleteExistingData = Cart::where('size', $request->size)
                ->where('product_id',$request->product_id)
                ->where('id','!=',$request->cart_id)
                ->delete();


            $getCartQtyOfProduct = Cart::where('product_id',$request->product_id)
                ->where('id',$request->cart_id)
                ->first();

            $ff = $getCartQtyOfProduct->cartqty * $request->price;

            $updateData = Cart::where('product_id',$request->product_id)
                ->where('id',$request->cart_id)
                ->update(['size' => $request->size, 'subtotal' => $ff ,'price' => $request->price
                ]);

        }else{
            $getCartQtyOfProduct = Cart::where('product_id',$request->product_id)
                ->where('id',$request->cart_id)
                ->first();

            $ff = $getCartQtyOfProduct->cartqty * $request->price;

            $updateData = Cart::where('product_id',$request->product_id)
                ->where('id',$request->cart_id)
                ->update(['size' => $request->size, 'subtotal' => $ff ,'price' => $request->price
                ]);

            $cartCount = Cart::where('ip_address',$user_ip)->count();
            $productsubtotal = Cart::where('ip_address',$user_ip)
                ->where('id',$request->cart_id)->select('subtotal')->first();
            $qty = Cart::where('ip_address',$user_ip)
                ->where('id',$request->cart_id)
                ->select('cartqty')->first();
            $cartSubtotal = Cart::where('ip_address',$user_ip)->sum('subtotal');

            return response()->json(['code'=>301,
                'cartCount' => $cartCount,
                'subtotal' => $productsubtotal,
                'qty' => $qty,
                'cartSubtotal' => $cartSubtotal,
                'status' => 'Cart Updated'
            ]);
        }

    }

    function updateQtyCart(Request $request){
        $user_ip = $this->getUserIP();

//        Array ( [product_id] => 4 [cartqty] => 2 [price] => 700 [cart_id] => 1 )
        $getCartQtyOfProduct = Cart::where('product_id',$request->product_id)
            ->where('id',$request->cart_id)
            ->first();

        $ff = $request->cartqty * $request->price;
        $sumofMsp = $getCartQtyOfProduct->msp * $request->cartqty;

        $updateData = Cart::where('product_id',$request->product_id)
            ->where('id',$request->cart_id)
            ->update(['cartqty' => $request->cartqty, 'subtotal' => $ff ,'price' => $request->price,
                'sumofmsp' => $sumofMsp
            ]);

        $cartCount = Cart::where('ip_address',$user_ip)->count();
        $productsubtotal = Cart::where('ip_address',$user_ip)
            ->where('id',$request->cart_id)->select('subtotal')->first();
        $qty = Cart::where('ip_address',$user_ip)
            ->where('id',$request->cart_id)
            ->select('cartqty')->first();
        $cartSubtotal = Cart::where('ip_address',$user_ip)->sum('subtotal');

        return response()->json(['code'=>301,
            'cartCount' => $cartCount,
            'subtotal' => $productsubtotal,
            'qty' => $qty,
            'cartSubtotal' => $cartSubtotal,
            'status' => 'Cart Updated'
        ]);

    }

    function deleteFromCart($id){
//        print_r($id);return false;
        $delete = Cart::where('id', $id)->delete();
        if ($delete == 1) {
            $success = true;
            $message = "Product Removed from cart";
        } else {
            $success = true;
            $message = "Product not found";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function updateCart(Request $request)
    {
//        print_r($request->all());die;
        $cartId = $request->input('cartId');
        $quantity = $request->input('quantity');

        // Update the cart in the database
        $cart = Cart::find($cartId);
        $cart->cartqty = (int)$quantity;
        $cart->subtotal = (float)$cart->per_piece_price *  (int)$quantity; // You may need to calculate the subtotal based on the price and quantity
        $cart->save();

        if(Auth::check()){
            $data['getAllCart'] = \App\Models\Cart::where('user_id', Auth::id())
                ->with([
                    'getProducts', 'getBrands', 'getSection'
                ])
                ->get();
            $getsubtotal = $data['getAllCart']->sum('subtotal');

        }else{
            $data['getAllCart'] = \App\Models\Cart::where('ip_address', $_SERVER['REMOTE_ADDR'])
                ->with([
                    'getProducts', 'getBrands', 'getSection'
                ])
                ->get();
            $getsubtotal = $data['getAllCart']->sum('subtotal');
        }


        // Return the updated subtotal to the frontend
        return response()->json(['updatedSubtotal' => $cart->subtotal,'sum_of_subtotal' => $getsubtotal]);
    }

    public function checkCoupon(Request $request)
    {

        $couponCode = $request->input('coupon_code');

        $couponDetails = Offer::where('code',$couponCode)->first();

        if (!$couponDetails) {
            // Coupon code is invalid or not found
            return response()->json(['error' => 'Invalid coupon code'], 422);
        }
        if(Auth::user()){
            $cartTotal = \App\Models\Cart::where('user_id',Auth::id())
                ->sum('subtotal');
        }else{
            $cartTotal = \App\Models\Cart::where('ip_address',$_SERVER['REMOTE_ADDR'])
                ->sum('subtotal');
        }

//        print_r($cartTotal);die;



        // Apply the discount based on the discount type
        if ($couponDetails->discount_type === 'flat') {
            // Flat amount deduction
            $discountAmount = $couponDetails['percentage_discount'];
        } elseif ($couponDetails->discount_type === 'percent') {
            // Percentage deduction
            $discountPercentage = $couponDetails['percentage_discount'];
            $discountAmount = ($discountPercentage / 100) * $cartTotal;
        } else {
            // Invalid discount type
            return response()->json(['error' => 'Invalid discount type'], 422);
        }

        // Calculate the discounted total
        $discountedTotal = $cartTotal - $discountAmount;
        // Store the applied coupon code and discounted total in the session
        Session::put('applied_coupon', $couponCode);
        Session::put('discounted_total', $discountedTotal);

        return response()->json(['discounted_total' => $discountedTotal]);
    }


    function checkout(Request $request){

        if(!Auth::check()){
            return redirect(url('login'));
        }
//        print_r($request->all());die;

        $data['page_heading'] = 'Checkout';
//        $data['sameBilling'] = $request->sameBilling;
//        if(isset($request->sameBilling)){
//            $data['sameBilling'] = '1';
//        }else{
//            $data['sameBilling'] = '0';
//        }



        $data['getAllCart'] = \App\Models\Cart::where('user_id',Auth::user()->id)
            ->with([
                'getProducts','getBrands','getSection', 'getColor'
            ])
            ->get();

        $data['getsubtotal'] = $data['getAllCart']->sum('subtotal');

        $data['user_addresses'] = UserAddress::where('user_id',Auth::user()->id)->get();

//        if(empty($data['user_address'])){
//            $data['user_address'] = $request->all();
//        }
//        print_r($data['getAllCart']);die;

        return view('web.checkout',$data);
    }

    function guest_checkout(Request $request){

        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'address_1' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
        ]);


        $data['sameBilling'] = $request->same_billing_details;
//        if(isset($request->same_billing_details)){
//            $data['sameBilling'] = '1';
//        }else{
//            $data['sameBilling'] = '0';
//        }

        $data['sameBilling'] = '1';
//        print_r($data);die;
        $data['page_heading'] = 'Checkout';
        $data['first_name'] = $request->first_name;
        $data['last_name'] = $request->last_name;
        $data['country'] = $request->country;
        $data['address_1'] = $request->address_1;
        $data['address_2'] = $request->address_2;
        $data['city'] = $request->city;
        $data['state'] = $request->state;
        $data['pincode'] = $request->pincode;
        $data['phone'] = $request->phone;
        $data['email'] = $request->email;

//        $data['getAllCart'] = \App\Models\Cart::where('ip_address',$_SERVER['REMOTE_ADDR'])
//            ->with([
//                'getProducts','getBrands','getSection'
//            ])
//            ->get();

//        print_r($data['getAllCart']);die;
        return view('web.guestcheckout',$data);
    }

    function guest_checkout1(Request $request){


        $data['sameBilling'] = '1';
//        print_r($data);die;
        $data['page_heading'] = 'Checkout';
        $data['first_name'] = $request->first_name;
        $data['last_name'] = $request->last_name;
        $data['country'] = $request->country;
        $data['address_1'] = $request->address_1;
        $data['address_2'] = $request->address_2;
        $data['city'] = $request->city;
        $data['state'] = $request->state;
        $data['pincode'] = $request->pincode;
        $data['phone'] = $request->phone;
        $data['email'] = $request->email;

        $data['getAllCart'] = \App\Models\Cart::where('ip_address',$_SERVER['REMOTE_ADDR'])
            ->with([
                'getProducts','getBrands','getSection'
            ])
            ->get();
        $data['getsubtotal'] = $data['getAllCart']->sum('subtotal');
//        print_r($data['getAllCart']);die;
        return view('web.guestcheckout',$data);
    }


    function addToWishlist(Request  $request){
        if(Auth::check()){
            $wishlist = new WishlistModel;
            $wishlist->product_id = $request->product_id;
            $wishlist->user_id = $request->user_id;
            $wishlist->status = '1';

            if($wishlist->save()){
                return response()->json(['code'=> 200,
                    'status' => 'Add to wishlist'
                ]);
            }else{
                return response()->json(['code'=> 400,
                    'status' => 'Something went wrong'
                ]);
            }
        }else{
            return response()->json(['code'=>404,
                'status' => 'Please login to continue'
            ]);
        }

    }


}
