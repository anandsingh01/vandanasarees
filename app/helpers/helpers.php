<?php

use App\Models\BannerModel;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

function getCommonSetting(){
    $commonSetting = \App\Models\CommonModel::first();
    return $commonSetting;

}
function get_footer_banner(){
    $get_footer_banner =   BannerModel::where([
        'display_area' => '4',
        'status' => '1',
    ])->orderBy('id', 'DESC')->first();

//    print_r($get_footer_banner);die;
    return $get_footer_banner;

}

function get_hero_banner(){
    $data = \App\Models\BannerModel::where('display_area','1')->where('status','1')->get();
    return $data;
}

function send_msg($senderid,$sendto,$message,$templateid){
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

}

function get_cart(){
    $user_ip = $_SERVER['REMOTE_ADDR'];
//    print_r($user_ip);die;

    if(Auth::check()){
        $count = \App\Models\Cart::where('user_id',Auth::id())->sum('cartqty');

        $getCartTotal = \App\Models\Cart::where('user_id',Auth::id())->sum('subtotal');
    }else{

        $count = \App\Models\Cart::where('ip_address',$user_ip)->sum('cartqty');

        $getCartTotal = \App\Models\Cart::where('ip_address',$user_ip)->sum('subtotal');
    }

    return json_encode(array('count' => $count, 'cartTotal' => $getCartTotal));
}

function get_wishlist(){
    $user_ip = $_SERVER['REMOTE_ADDR'];

    // Initialize $count with 0
    $count = 0;

    if (Auth::check()) {
        $count = \App\Models\WishlistModel::where('user_id', Auth::id())->count('product_id');
    }

    return json_encode(array('count' => $count, 'cartTotal' => $count));
}

function getCartProducts(){


    if(Auth::check()){
        $getAllCart = \App\Models\Cart::where('user_id',Auth::id())
            ->with([
                'getProducts'
            ])
            ->get();

    }else{

        $getAllCart = \App\Models\Cart::where('ip_address',$_SERVER['REMOTE_ADDR'])
            ->with([
                'getProducts'
            ])
            ->get();
    }


    return $getAllCart;
}

function getRelatedProducts($id){
    $data['product'] = \App\Models\Product::where('brands_id',$id)
        ->with(
            'getPrices',
            'getGallery',
            'get_brands',
            'section'
        )
        ->get();
    return $data;
}
function get_category(){
    $category = Category::where([
        'status' => '1',
        'show_on_homepage' => '1',
        'category_type' => 'section'
    ])->get();

    return $category;
}
function get_brands(){
    $data = \App\Models\Category::where('category_type','brands')->where('status','1')->get();
    return $data;
}


function sendOrderRequest($orderData) {
    $url = 'https://shipping-api.com/app/api/v1/push-order';
    $privateKey = 'wN5XhnmHM72iDf8PEt6Z';
    $publicKey = 'xCfJuiWSGAksYUPl6eB8';

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($orderData),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            "private-key: $privateKey",
            "public-key: $publicKey"
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    return $response;
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


?>
