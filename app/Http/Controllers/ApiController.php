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

class ApiController extends Controller{

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

    public function sendOrderConfirmationSMS($phone, $first_name, $order_id) {
        $senderId = 'Groovv';
        $message = "Hi $first_name, Thanks for placing your order with us. Your Order tracking Id is - $order_id. Track your order on - Grooveslifestyle.com";
        $templateId = '1707170454029388175';
        $username = 'grooves';
        $password = '887200';
        $PEID = '';
        $apiUrl = "http://45.249.108.134/api.php";

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'username' => $username,
            'password' => $password,
            'sender' => $senderId,
            'sendto' => $phone,
            'message' => $message,
            'PEID' => $PEID,
            'templateid' => $templateId,
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    public function sendCustomSMS($senderId, $sendTo, $message, $templateId) {

        echo "ab";
        print_r($senderId);die;
        $username = 'grooves';
        $password = '887200';
        $PEID = '';
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
            'PEID' => $PEID,
            'templateid' => $templateId,
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }



}
