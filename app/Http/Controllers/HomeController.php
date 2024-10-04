<?php

namespace App\Http\Controllers;
use Twilio\Rest\Client;
use App\Models\AboutModels;
use App\Models\AnnualReportModel;
use App\Models\BannerModel;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Offer;
use App\Models\Product;
use App\Models\ReviewModel;
use App\Models\RegisterProduct;
use App\Models\Claimwarranty;
use App\Models\Otp;
use App\Models\Section;
use App\Models\User;
use Easyship\Facades\Easyship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Expr\New_;
use Session;
use Intervention\Image\Facades\Image;
use Auth;
class HomeController extends Controller
{

    public function otp_for_cod(Request $request) {
//        print_r($request->all());die;
        $otp = rand(1111,9999);
        $saveOtp = new Otp;
        $saveOtp->userid = $request->phone;
        $saveOtp->otp = $otp;
        $saveOtp->status = 0;
        $saveOtp->save();

        $senderId = 'Groovv';
        $sendTo = $request->phone;
        $message = "Dear User Your OTP for Logging in to Grooves account is ".$otp." Valid for 5 min - Grooveslifestyle";
        $templateId = '1707170454023448070';

        $username = 'grooves';
        $password = '887200';
        $senderId = $senderId;
        $sendTo = $sendTo; // Replace with the actual phone number
        $message = $message;
        $PEID = '';
        $templateId = $templateId;

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
//            return $response;

        return response(['code' => 200]);
    }


    public function verify_codotp(Request $request) {

//        print_r($request->all());die;
        $get_otp = Otp::where('userid',$request->phone)
            ->where('otp',$request->otp)
            ->orderBy('id','desc')
            ->first();

        if(!empty($get_otp)){
//            $getUSer =  \Illuminate\Support\Facades\Auth::loginUsingId($checkUser->id); // Use Auth::login() instead of Auth::loginUsingId()
//                print_r($getUSer);die;
            return response(['code' => 200]);
        }else{
            return response(['code' => 404]);
        }

    }


    public function index()
    {
        $data['get_hero_banner'] = BannerModel::where([
            'display_area' => '1',
            'status' => '1',
        ])->get();

        $data['section_on_home'] = Section::where([
            'status' => '1',
            'show_on_homepage' => '1',
        ])->get();

        $data['category_on_home'] = Category::where([
            'status' => '1',
        ])->get();

//                print_r( $data['category_on_home']);die;

        $data['products'] = Product::with('sections','product_category')->get();
//
        $data['get_sarees'] = Product::where([
            'section_id' => '1',
        ])
            ->with('sections', 'product_category', 'getGallery')
            ->limit(12)
            ->get();

//        print_r($data['get_sarees']);
//        die;


        $data['get_recent_product'] = Product::where([
            'status' => '1',
            'highlights' => '1'
        ])
            ->orderBy('id', 'DESC')
            ->with('sections', 'product_category', 'getGallery')
            ->limit(4)
            ->get();

//                print_r($data['get_recent_product']);die;


        $data['get_below_banner'] = BannerModel::where([
            'display_area' => '2',
            'status' => '1',
        ])->orderBy('id', 'DESC')->first();


        $data['get_middle_banner'] = BannerModel::where([
            'display_area' => '3',
            'status' => '1',
        ])->orderBy('id', 'DESC')->first();

        $data['get_mystic_banner'] = BannerModel::where([
            'display_area' => '8',
            'status' => '1',
        ])->orderBy('id', 'DESC')->first();

//        print_r($data['get_mystic_banner']);die;


        $data['reviews'] = ReviewModel::where('added_by','1')->get();
//        print_r($data['reviews']);die;
        $data['offers'] = Offer::where('show_at_homepage','1')->latest()->first();
        $data['offers_list'] = Offer::where('show_at_homepage','1')
            ->where('is_featured','0')->limit(3)->get();
//// Fetch Instagram posts
//        $accessToken = session('instagram_access_token');
//
//        if (!$accessToken) {
//            return redirect('/instagram/authorize'); // Redirect to Instagram authorization if no token found
//        }
//
//        // Fetch Instagram posts using the access token
//        $response = Http::get("https://graph.instagram.com/me/media", [
//            'fields' => 'id,caption,media_url,permalink',
//            'access_token' => $accessToken,
//        ]);

        // Add Instagram posts to the data array
//        $data['instagram_posts'] = $response->json()['data'] ?? [];
        $data['instagram_posts'] =  [];
//        print_r($data['instagram_posts']);die;
        return view('web.index', $data);
    }

    function product_by_category($slug)
    {
        $data['sections'] = Section::with('get_products')->where('slug', $slug)->first();
        $data['categories'] = Category::where('status', '1')->get();
//        print_r($data['categories']);die;
        return view('web.shop', $data);
    }

    function shop()
    {
        $data['get_products'] = Product::where([
                'status' => '1',
            ])
            ->orderBy('id', 'DESC')
            ->paginate(16);
//        print_r($data);die;
        return view('web.shop', $data);
    }

    function brands()
    {
        $data['get_products'] = Product::where([
                'status' => '1',
            ]
        )
            ->with('get_brands', 'section')
            ->orderBy('id', 'DESC')
            ->get();
        return view('web.brands', $data);
    }

    function product_by_brands($slug)
    {
        $brands = Category::where('slug', $slug)->first();
        if (!empty($brands)) {
            $data['get_products'] = Product::where([
                    'brands_id' => $brands->id,
                    'status' => '1',
                ]
            )
                ->with('get_brands', 'section')
                ->orderBy('id', 'DESC')
                ->get();
            $data['category'] = $brands;
        }
        return view('web.brands_product', $data);
    }

    function contactus()
    {
        return view('web.contact');
    }


    function products_details($url)
    {
        $data['get_middle_banner'] = BannerModel::where([
            'display_area' => '3',
            'status' => '1',
        ])->orderBy('id', 'DESC')->first();

        $data['product'] = Product::where('slug', $url)
            ->with(
                'getPrices',
                'getGallery',
                'get_brands',
                'sections',
                'getProductAttr'
            )
            ->first();

        $data['get_sarees'] = Product::where([
            'section_id' => '1',
        ])
            ->with('sections', 'product_category', 'getGallery')
            ->limit(12)
            ->get();
//        print_r($data['product']);die;
        if(!empty($data['product'])){
            return view('web.product-details', $data);
        }else{
            return view('web.product-details', $data);

        }

    }
    public function getProductDetails($id)
    {
        $product = Product::where('id', $id)
            ->with(
                'getPrices',
                'getGallery',
                'get_brands',
                'sections'
            )
            ->first();
        // Fetch additional details if needed

//        print_r($product);die;

        return response()->json([
            'success' => true,
            'product' => $product->toArray(),
            // Include additional data as needed
        ]);
    }

//    function products_details($url)
//    {
//        $data['get_middle_banner'] = BannerModel::where([
//            'display_area' => '3',
//            'status' => '1',
//        ])->orderBy('id', 'DESC')->first();
//
//        $data['product'] = Product::where('slug', $url)
//            ->with(
//                'getPrices',
//                'getGallery',
//                'get_brands',
//                'sections'
//            )
//            ->first();
////        print_r($data['product']);die;
//        if(!empty($data['product'])){
//            return view('web.product-details', $data);
//        }else{
//            return view('web.product-details', $data);
//
//        }
//
//    }

    public function searchTitle(Request $request)
    {
//        print_r($request->all());die;
        $query = $request->input('query');
        // Query the products table for titles matching the query
        $products = Product::where('title', 'like', '%' . $query . '%')->where('status', '=', '1' )->get()->pluck('title', 'slug');

        return $products;
    }

    public function filter(Request $request)
    {
//        print_r($request->all());die;
//        $selectedCategories = $request->input('categories', []);
//        $selectedBrands = $request->input('brands', []);
//        $selectedProductTypes = $request->input('productTypes', []);
//        $selectedSizes = $request->input('productSizes', []); // Use 'input' for productSizes
//
////        print_r($selectedCategories);die;
//
//        $query = Product::query();
//
//        if (!empty($selectedCategories) && !in_array('all', $selectedCategories)) {
//            $query->whereIn('section_id', $selectedCategories);
//        }
//        if (!empty($selectedBrands) && !in_array('all', $selectedBrands)) {
//            $query->whereIn('brands_id', $selectedBrands);
//        }
//
//        if (!empty($selectedProductTypes)) {
//            $query->whereIn('product_type', $selectedProductTypes);
//        }
//
//        // Check if "All" is selected for sizes, if not, add size filtering
//        if (!empty($selectedSizes) && !in_array('productsize-all', $selectedSizes)) {
//            $query->selectRaw('products.id, products.title, products.section_id, products.brands_id, products.product_type, products.photo, products.slug, products.product_actual_price')
//                ->join('product_size_attributes', 'products.id', '=', 'product_size_attributes.product_id')
//                ->whereIn('product_size_attributes.size', $selectedSizes)
//                ->groupBy('products.id', 'products.title', 'products.section_id', 'products.brands_id', 'products.product_type', 'products.photo', 'products.slug', 'products.product_actual_price');
//        }
//
//        // Execute the query to retrieve filtered products
//        $filteredProducts = $query->get();
//
//        // Return all products if "All" sizes are selected
//        if (in_array('all', $selectedSizes)) {
//            $filteredProducts = Product::all();
//        }
//
//        $filteredProducts = $query->get();
//
//        if ($request->ajax()) {
//            return view('web.filtered_products', ['get_products' => $filteredProducts]);
//        }

        $selectedCategories = $request->input('categories', []);
        $selectedBrands = $request->input('brands', []);
        $selectedProductTypes = $request->input('productTypes', []);
        $selectedSizes = $request->input('productSizes', []);

        $query = Product::query();

        if (!empty($selectedCategories) && !in_array('all', $selectedCategories)) {
            $query->whereIn('section_id', $selectedCategories);
        }
        if (!empty($selectedBrands) && !in_array('all', $selectedBrands)) {
            $query->whereIn('brands_id', $selectedBrands);
        }

        if (!empty($selectedProductTypes)) {
            $query->whereIn('product_type', $selectedProductTypes);
        }

// Check if "All" is selected for sizes, if not, add size filtering
        if (!empty($selectedSizes) && !in_array('productsize-all', $selectedSizes)) {
            $query->selectRaw('products.id, products.title, products.section_id, products.brands_id, products.product_type, products.photo, products.slug, products.product_actual_price')
                ->join('product_size_attributes', 'products.id', '=', 'product_size_attributes.product_id')
                ->whereIn('product_size_attributes.size', $selectedSizes)
                ->groupBy('products.id', 'products.title', 'products.section_id', 'products.brands_id', 'products.product_type', 'products.photo', 'products.slug', 'products.product_actual_price');
        }

// Check if any selected checkbox is deselected
        if (in_array('all', $selectedCategories) || in_array('all', $selectedBrands) || in_array('all', $selectedProductTypes) || in_array('productsize-all', $selectedSizes)) {
            $filteredProducts = Product::orderBy('id', 'desc')->get();
        } else {
            // Execute the query to retrieve filtered products
            $filteredProducts = $query->orderBy('id', 'desc')->get();
        }

        if ($request->ajax()) {
            return view('web.filtered_products', ['get_products' => $filteredProducts]);
        }


    }

    public function filter_by_price(Request $request)
    {
        // Your existing code to get selected categories and brands

        $selectedCategories = $request->input('categories', []);
        $selectedBrands = $request->input('brands', []);
        $sortBy = $request->input('sortby'); // Get the selected sorting option
        $currentCategoryId = $request->input('category_id');

        $query = Product::query();

        if (!empty($selectedCategories)) {
            $query->whereIn('section_id', $selectedCategories);
        }

        if (!empty($selectedBrands)) {
            $query->whereIn('brands_id', $selectedBrands);
        }


        $filteredProducts = $query;

        if ($sortBy === 'lowtohigh') {
            $filteredProducts = $filteredProducts->orderBy('product_actual_price', 'asc');
        } elseif ($sortBy === 'hightolow') {
            $filteredProducts = $filteredProducts->orderBy('product_actual_price', 'DESC');
        } elseif ($sortBy === 'newarrivals') { // Remove the extra space after 'newarrivals'
            $filteredProducts = $filteredProducts->orderBy('created_at', 'desc'); // Assuming 'created_at' is the timestamp for new arrivals
        }

        $filteredProducts = $filteredProducts->get();

        // If no categories and brands are selected, sort all products based on the selected sorting option

        if (empty($selectedCategories) && empty($selectedBrands)) {
            $allProductsQuery = Product::query();

            if ($sortBy === 'lowtohigh') {

                $filteredProducts = $allProductsQuery->orderBy('product_actual_price', 'asc');

            }
            elseif ($sortBy === 'hightolow') {

                $filteredProducts = $allProductsQuery->orderBy('product_actual_price', 'DESC');

            }
            elseif ($sortBy === 'newarrivals') {

                $filteredProducts = $allProductsQuery->orderBy('created_at', 'desc');

            }

            $filteredProducts = $allProductsQuery->get();

        }

        if ($request->ajax()) {
            return view('web.shop', ['get_products' => $filteredProducts])->render();
        }



    }


    function blogs()
    {
        $data['all_blogs'] = Blog::where('status','1')
            ->orderBy('id','DESC')
            ->get();

        return view('web.blogs',$data);
    }
    function blogs_details($blog)
    {
        $data['all_blog'] = Blog::where('title_slug',$blog)
            ->first();

        return view('web.blogs_details',$data);
    }

    function get_easyship()
    {

//        9 N Fordham Rd Hicksville 11801 New York - Long island Fragrances Long Island
// Fragrances 5168141663 lifragrancesny@gmail.com

        $ch = curl_init();

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
                "state" => "US/TX",
                "postal_code" => "75022",
                "city" => "Flower Mound",
                "country_alpha2" => "US",
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
                "apply_shipping_rules" => true,
                'selected_courier_id' => 'a6d078fd-e662-40ce-9efe-84caaa639bf7'
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
                        "length" => "10",
                        "width" => "10",
                        "height" => "10"
                    ),
                    "items" => array(
                        array(
                            "quantity" => "1",
                            "dimensions" => array(
                                "width" => "20",
                                "length" => "20",
                                "height" => "10"
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

        $data_string = json_encode($data);

        curl_setopt($ch, CURLOPT_URL, "https://api.easyship.com/2023-01/rates");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_POST, TRUE);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Bearer prod_Et5YFzWn5FA3co/3ddpC33pzqgjnzjM9CXUtTkPgbCM="
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        print_r(json_decode($response));

        die;
    }

    function ship(){


        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.easyship.com/2023-01/shipments",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'origin_address' => [
                    'line_1' => '9 N Fordham Rd',
                    'state' => 'US/NY',
                    'city' => 'Hicksville',
                    'postal_code' => '11801',
                    'country_alpha2' => 'US',
                    'company_name' => 'test',
                    'contact_name' => 'test',
                    'contact_phone' => '+15168141663',
                    'contact_email' => 'test@test.com'
                ],
                'sender_address' => [
                    'line_1' => '9 N Fordham Rd',
                    'state' => 'US/NY',
                    'city' => 'Hicksville',
                    'postal_code' => '11801',
                    'country_alpha2' => 'US',
                    'company_name' => 'test',
                    'contact_name' => 'test',
                    'contact_phone' => '+15168141663',
                    'contact_email' => 'test@test.com'
                ],
                'return_address' => [
                    'line_1' => '9test d',
                    'state' => 'US/NY',
                    'city' => 'Hicksville',
                    'postal_code' => '11801',
                    'country_alpha2' => 'US',
                    'company_name' => 'test',
                    'contact_name' => 'test',
                    'contact_phone' => '+15168141663',
                    'contact_email' => 'test@test.com'
                ],
                'destination_address' => [
                    'line_1' => '2451 lakeside pkwy',
                    'state' => 'Texas',
                    'city' => 'Hicksville',
                    'postal_code' => '11801',
                    'country_alpha2' => 'US',
                    'contact_name' => 'TEST',
                    'contact_phone' => '+14805279803',
                    'contact_email' => 'lifragrancesny@gmail.com'
                ],
                'incoterms' => 'DDU',
                'insurance' => [
                    'is_insured' => false
                ],
                'courier_selection' => [
                    'selected_courier_id' => 'a6d078fd-e662-40ce-9efe-84caaa639bf7',
                    'allow_courier_fallback' => false,
                    'apply_shipping_rules' => true
                ],
                'shipping_settings' => [
                    'additional_services' => [
                        'qr_code' => 'none'
                    ],
                    'units' => [
                        'weight' => 'kg',
                        'dimensions' => 'cm'
                    ],
                    'buy_label' => false,
                    'buy_label_synchronous' => false,
                    'printing_options' => [
                        'format' => 'png',
                        'label' => '4x6',
                        'commercial_invoice' => 'A4',
                        'packing_slip' => '4x6'
                    ]
                ],
                'parcels' => [
                    [
                        'box' => [
                            'length' => 3.93,
                            'width' => 3.93,
                            'height' => 3.93,
                            'slug' => 'null'
                        ],
                        'items' => [
                            [
                                'dimensions' => [
                                    'length' => 1,
                                    'width' => 1,
                                    'height' => 1
                                ],
                                'category' => 'health_beauty',
                                'description' => 'This is a nice product',
                                'sku' => 'PRD-123',
                                'contains_battery_pi966' => false,
                                'contains_battery_pi967' => false,
                                'origin_country_alpha2' => 'US',
                                'quantity' => 1,
                                'contains_liquids' => false,
                                'actual_weight' => 5,
                                'declared_currency' => 'USD',
                                'declared_customs_value' => 1
                            ]
                        ],
                        'total_actual_weight' => 1,
                        'selected_courier_id' =>  '2030dd90-a00d-4fec-bc9d-f71e006419c2',
                    ]
                ]
            ]),
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Bearer prod_Et5YFzWn5FA3co/3ddpC33pzqgjnzjM9CXUtTkPgbCM=",
                "content-type: application/json"
            ],
        ]);

        $response = curl_exec($curl);

        print_r(json_decode($response));die;


        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }


    }

    function save_review(Request $request){
//        print_r($request->all());
        if(Auth::check()){
            $username = Auth::user()->name;
        }else{
            $username = 'Anonymous';
        }

        $review = new \App\Models\ReviewModel;
        $review->username = $username ?? 'users';
        $review->product_id = $request->product_id;
        $review->rating = $request->rating;
        $review->review = $request->review;
        $review->status = 0;

        if($review->save()){
            return redirect()->back()->with('review_success','Review will update soon');
        }
    }
    function send_enquiry(Request $request){
//        print_r($request->all());die;

        // Get form data
        $name = $request->name;
        $phone = $request->phone;
        $email = $request->email;
        $message =  $request->message;

        $enquiry = new \App\Models\Enquiry;
        $enquiry->name = $name;
        $enquiry->phone = $phone;
        $enquiry->email = $email;
        $enquiry->message = $message;

        $enquiry->save();


        // print_r($message);die;

        // Validate form data (you can add your own validation here)

        // Prepare email message
        $to = "lifragrancesny@gmail.com";
//    $to = "pandu.karteek@gmail.com";
//    $to = "anandsingh678970@gmail.com";
        $subject = "New Contact Form Submission";
        $email_content = "Name: " . $name . "\n";
        $email_content .= "Phone: " . $phone . "\n";
        $email_content .= "Email: " . $email . "\n";
        $email_content .= "Message: " . $message . "\n";
        $headers = "From: " . $email . "\r\n";

        // Send email
        if (mail($to, $subject, $email_content, $headers)) {
            // Email sent successfully
            $success_message = "Thank you for your message. We will get back to you soon.";

            Session::flash('enquiry_sent',$success_message);
            return redirect($_SERVER['HTTP_REFERER']);
        } else {
            // Error sending email
            $success_message = "Oops! Something went wrong. Please try again later.";
            Session::flash('enquiry_sent',$success_message);
            return redirect($_SERVER['HTTP_REFERER']);

        }
    }

    function faq(){
        $data['faq'] = \App\Models\Faq::where('status','1')->get();
        return view('web.faq',$data);
    }

//    create shipment

//function creatE_shipment(Request $request){
//    $items = [];
//
//    foreach ($request->product_name as $key => $value) {
//        $item = [
//            'description' => 'null',
//            'category' => 'health_beauty', // Modify as needed
//            'sku' => 'Prod_id'.$request->product_id[$key].'-'.$request->product_name[$key],
//            'declared_currency' => 'USD', // Modify as needed
//            'declared_customs_value' => (int)$request->price[$key],
//            'quantity' => (int)$request->qty[$key],
//        ];
////            print_r($item);
//
//        $items[] = $item;
//    }
//
//    $curl = curl_init();
//
//    curl_setopt_array($curl, [
//        CURLOPT_URL => "https://api.easyship.com/2023-01/shipments",
//        CURLOPT_RETURNTRANSFER => true,
//        CURLOPT_ENCODING => "",
//        CURLOPT_MAXREDIRS => 10,
//        CURLOPT_TIMEOUT => 30,
//        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//        CURLOPT_CUSTOMREQUEST => "POST",
//        CURLOPT_POSTFIELDS => json_encode([
//            'origin_address' => [
//                'line_1' => '9 N Fordham Rd',
//                'state' => 'New York',
//                'city' => 'Hicksville',
//                'postal_code' => '11801',
//                'country_alpha2' => 'US',
//                'company_name' => 'Long island Fragrances',
//                'contact_name' => 'Long island Fragrances',
//                'contact_phone' => '5168141663',
//                'contact_email' => 'lifragrancesny@gmail.com',
//            ],
//            'sender_address' => [
//                'line_1' => '9 N Fordham Rd',
//                'state' => 'New York',
//                'city' => 'Hicksville',
//                'postal_code' => '11801',
//                'country_alpha2' => 'US',
//                'company_name' => 'Long island Fragrances',
//                'contact_name' => 'Long island Fragrances',
//                'contact_phone' => '5168141663',
//                'contact_email' => 'lifragrancesny@gmail.com',
//            ],
//            'return_address' => [
//                'line_1' => '9 N Fordham Rd',
//                'state' => 'New York',
//                'city' => 'Hicksville',
//                'postal_code' => '11801',
//                'country_alpha2' => 'US',
//                'company_name' => 'Long island Fragrances',
//                'contact_name' => 'Long island Fragrances',
//                'contact_phone' => '5168141663',
//                'contact_email' => 'lifragrancesny@gmail.com',
//            ],
//            'destination_address' => [
//                'line_1' => $request->address_1,
//                'line_2' => $request->address_2,
//                'state' => $request->state,
//                'city' => $request->city,
//                'postal_code' => $request->pincode,
//                'country_alpha2' => 'US',
//                'contact_name' => $request->first_name .' '. $request->last_name ,
//                'contact_email' => $request->email,
//                'contact_phone' => $request->phone
//            ],
//            'incoterms' => 'DDU',
//            'insurance' => [
//                'is_insured' => false,
//            ],
//            'order_data' => [
//                'platform_name' => 'API',
//                'platform_order_number' => rand(111111,999999),
//                'order_tag_list' => [
//                    null
//                ],
//                'seller_notes' => 'null',
//                'buyer_notes' => 'null'
//            ],
//            'courier_selection' => [
//                'allow_courier_fallback' => true,
//                'apply_shipping_rules' => false,
//                'selected_courier_id' => $request->selected_courier,
//                'list_unavailable_couriers' => true
//            ],
//            'shipping_settings' => [
//                'additional_services' => [
//                    'qr_code' => 'none',
//                    'delivery_confirmation' => 'ups_delivery_confirmation_verbal'
//                ],
//                'units' => [
//                    'weight' => 'lb',
//                    'dimensions' => 'cm'
//                ],
//                'buy_label' => false,
//                'buy_label_synchronous' => false,
//                'printing_options' => [
//                    'format' => 'png',
//                    'label' => '4x6',
//                    'commercial_invoice' => 'A4',
//                    'packing_slip' => '4x6'
//                ]
//            ],
//            'parcels' => [
//                [
//                    'box' => [
//                        'slug' => 'null',
//                        'length' => $request->sum_length[0],
//                        'width' => $request->sum_width[0],
//                        'height' => $request->sum_height[0]
//                    ],
//                    'items' => $items,
//                    'total_actual_weight' => 1
//                ]
//            ]
//        ]),
//        CURLOPT_HTTPHEADER => [
//            "accept: application/json",
//            "authorization: Bearer prod_Et5YFzWn5FA3co/3ddpC33pzqgjnzjM9CXUtTkPgbCM=",
//            "content-type: application/json"
//        ],
//    ]);
//
//    $response = curl_exec($curl);
//    $err = curl_error($curl);
//
//    curl_close($curl);
//
//    if ($err) {
//        echo "cURL Error #:" . $err;
//    } else {
//        echo $response;
//    }
//
//    if(!empty(json_decode($response))){
//        Session::put('shpping_rates',$response);
//    }
//}

function subscribe_newseletter(Request  $request){
        $newsletter = new \App\Models\Newsletter;
        $newsletter->email = $request->email;
        $newsletter->status = '0';
        $newsletter->save();
        return redirect(url('/'))->with('newsletter_success','Subscribed To Newsletter.');
}


function register_product(Request $request){

        $register_product = new RegisterProduct;
        $register_product->name = $request->name;
        $register_product->email = $request->email;
        $register_product->phone = $request->phone;
        $register_product->product_category = $request->product_category;
        $register_product->purchased_from = $request->purchased_from;
        $register_product->purchased_date = $request->purchased_date;
        $register_product->invoice_number = $request->invoice_number;
        $register_product->status = $request->status;

        if($register_product->save()){
            Session::flash('register_success','Product Register Successfully');
            return Redirect::back();

        }else{
            Session::flash('register_success','Product Register Successfully');
            return Redirect::back();
        }
        print_r($request->all());die;
}

function claim_warranty(Request $request){
//    print_r($request->all());die;

        $register_product = new Claimwarranty;
        $register_product->name = $request->name;
        $register_product->email = $request->email;
        $register_product->phone = $request->phone;
    $register_product->purchased_date = $request->purchased_date;
    $register_product->invoice_number = $request->invoice_number;
    $register_product->product_category = $request->product_category;
        $register_product->point_of_purchase = $request->point_of_purchase;
        $register_product->issueCategory = $request->issueCategory;
        $register_product->description = $request->description;

    // Check if the image file was uploaded
    if ($request->hasFile('images')) {
        $image = $request->file('images');
        $path = 'images';
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move($path, $imageName);
        $webpImagePath = 'images/webp/' .rand(1111,9999).time(). '.webp';
        Image::make($path . '/' . $imageName)->encode('webp')->save($webpImagePath, 80);
        $register_product->images = $webpImagePath;
    }

    $register_product->status = $request->status;

        if($register_product->save()){
            Session::flash('register_success','Product Register Successfully');
            return Redirect::back();

        }else{
            Session::flash('register_success','Product Register Successfully');
            return Redirect::back();
        }
    }


    function testingotp() {
        // API URL and API Key
        $destinationPhoneNumber = '917355420160';
        $apiUrl = "https://api.gupshup.io/wa/api/v1/template/msg";
        $apiKey = "6449wdtgatngjnt2wu2zqd6upgtjsdkc";  // Replace with your actual API key
        $sourceNumber = "919795268402";  // Your Gupshup-provided source number
        $srcName = "shtesting1";  // Your registered source name
        $templateId = "0be33024-00de-4b2e-9600-8d9b1da932c9";  // Template ID

        // Prepare the POST data
        $postData = http_build_query(array(
            'channel' => 'whatsapp',
            'source' => $sourceNumber,
            'destination' => $destinationPhoneNumber,
            'src.name' => $srcName,
            'template' => json_encode(array(
                'id' => $templateId,
                'params' => array(
                    'First parameter',   // First parameter in the template
                    'second',     // Second parameter
                    'third',    // Third parameter
                    'fourth'        // Fourth parameter
                )
            ))
        ));

        // Initialize cURL
        $ch = curl_init();

        // cURL options
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Cache-Control: no-cache',
            'Content-Type: application/x-www-form-urlencoded',
            'apikey: ' . $apiKey
        ));

        // Execute the request
        $response = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        } else {
            echo 'Response: ' . $response;
        }

        // Close cURL
        curl_close($ch);
    }


}
