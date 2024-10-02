<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function register(Request $request)
    {
//        print_r($request->all());die;
        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $password = $request->input('password');

        $checkUser = User::where('email',$email)->count();
        if($checkUser == 0){
            $user = new User();

            $user->name = $name;
            $user->email = $email;
            $user->password = Hash::make('12345678');
            $user->salt_password = '12345678';
            $user->mobile_number = $phone;
            $user->role = '2';
            $user->status = '0';

            $token = \Str::random(64);

            $user->save();

            $emailVerification = new \App\Models\UserVerify;
            $emailVerification->userid	 =  $user->id;
            $emailVerification->token = $token;
            $emailVerification->status = 0;
            $emailVerification->save();

            // API URL and API Key
            $destinationPhoneNumber = $phone;
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
//
//            $email = $user->email;
//            $data1['created_at'] = $user->email;
//
//            $message = "Hurray! You're truly special to us. Make your own statement with India's leading audio brand -Grooves . For special discounts, visit www.grooveslifestyle.com";
//
//            $username = 'grooves';
//            $password = '887200';
//            $senderId = 'Groovv';
//            $sendTo = $phone; // Replace with the actual phone number
//            $message = $message;
//            $PEID = '';
//            $templateId = '1707170453825822776';
//
//// Build the API URL
//            $apiUrl = "http://45.249.108.134/api.php";
//
//// Set up the curl request
//            $ch = curl_init($apiUrl);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//            curl_setopt($ch, CURLOPT_POST, true);
//            curl_setopt($ch, CURLOPT_POSTFIELDS, [
//                'username' => $username,
//                'password' => $password,
//                'sender' => $senderId,
//                'sendto' => $sendTo,
//                'message' => $message,
//                'PEID' => $PEID,
//                'templateid' => $templateId,
//            ]);
//
//// Execute the request
//            $response = curl_exec($ch);
//
//// Close the curl session
//            curl_close($ch);
//
//// Process the response as needed
//            echo $response;

//            print_r($email);die;
//            \Mail::send('emails.UserVerification',['token' => $token] , function($message) use($request){
//                $message->to($request->input('email')); // Use $request to get the email
//                $message->subject('Email Verification Mail');
//            });
//
//			  \Mail::send('emails.welcome', $data1, function($message) use($request){
//                $message->to($request->input('email')); // Use $request to get the email
//                $message->subject('Welcome To Infiarc');
//            });

            Auth::login($user);

            return redirect(url('my-profile'));
        }else{
            \Session::flash('error','Email Already Registered');
            return redirect(url('/'));
        }



    }

}
