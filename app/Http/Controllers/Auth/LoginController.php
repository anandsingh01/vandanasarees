<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;
use Facebook\Facebook;
use Session;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function redirectToGoogle()
    {
        // Redirect the user to Google OAuth consent screen
        $authUrl = "https://accounts.google.com/o/oauth2/auth?"
            . "client_id=626981179793-jqjh8fcvqsqb4gajsbaes4uaub6seh76.apps.googleusercontent.com"
            . "&redirect_uri=".url("/google/callback")
            . "&scope=https://www.googleapis.com/auth/userinfo.email+https://www.googleapis.com/auth/userinfo.profile"
            . "&response_type=code";

        header("Location: $authUrl");
        exit();
    }

    public function handleGoogleCallback(Request $request)
    {
//        print_r($request->all());die;
        if (isset($_GET['code'])) {
            $data = array(
                'code' => $_GET['code'],
                'client_id' => "626981179793-jqjh8fcvqsqb4gajsbaes4uaub6seh76.apps.googleusercontent.com",
                'client_secret' => "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",
                'redirect_uri' => url("/google/callback"),
                'grant_type' => 'authorization_code'
            );

            $ch = curl_init('https://oauth2.googleapis.com/token');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            curl_close($ch);

            $tokenData = json_decode($response, true);

//            print_r($tokenData);die;
            $accessToken = $tokenData['access_token'];


            // Now you have the access token, use it to fetch user data
            $url = 'https://www.googleapis.com/oauth2/v2/userinfo';
            $headers = array('Authorization: Bearer ' . $accessToken);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $profileResponse = curl_exec($ch);
            curl_close($ch);

            $profileData = json_decode($profileResponse, true);

//            print_r($profileData['email']);die;/
            // Check if the user exists in your database based on the Google email
            $existingUser = User::where('email', $profileData['email'])->first();

            if ($existingUser) {
                Auth::login($existingUser);
            } else {
                // If the user does not exist, create a new user record in your database

                $checkUser = User::where('email',$profileData['email'])->count();
                if($checkUser == 0){
                    $newUser = new User();
                    $newUser->name = $profileData['name'];
                    $newUser->email = $profileData['email'];
                    $newUser->password = Hash::make($profileData['email']);
                    $newUser->salt_password = $profileData['email'];
                    $newUser->role = '2';
                    $newUser->register_method = '2';
                    $newUser->save();
                    Auth::login($newUser);
                }else{
                    $getUser = User::where('email',$profileData['email'])
                        ->where('register_method','2')
                        ->first();
                    if(!empty($getUser)){
                        Auth::loginUsingId($getUser);
                    }else{
                        \Session::flash('error','Username or Password is incorrect');
                        return redirect(url('login'));
                    }
                }

            }

            return redirect(url('/'));
        } else {
            Session::flash('error','Something went wrong. Try again');
            return redirect(url('/login'));
        }
    }

// Inside a controller or a helper file
    function generateAppSecretProof($appSecret, $accessToken) {
        return hash_hmac('sha256', $accessToken, $appSecret);
    }
// Redirect to Facebook for authorization
    public function redirectToFacebook()
    {

        $facebookAppId = '650775210103068';
        $facebookAppSecret = 'bb6b4fd2931f77212fb2701aa5570808';
//        $redirectUri = 'http://localhost:8000/facebook-callback';
        $redirectUri = 'https://lifragrances.com/facebook/callback';
        $scope = 'email';
        //Call Facebook API
        $facebook = new Facebook(array(
            'appId'  => $facebookAppId,
            'secret' => $facebookAppSecret
        ));
        $fbUser = $facebook->getUser();
        print_r($fbUser);
        die;
        $responseData = $response->getDecodedBody();

        if (isset($responseData['error'])) {
            var_dump($responseData['error']);
        } else {
            print_r($responseData);
        }


        die;

        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email']; // Add any additional permissions you need
        $loginUrl = $helper->getLoginUrl(url('/facebook/callback'), $permissions);

//        print_r($loginUrl);die;

        return redirect($loginUrl);
    }

// Handle Facebook Callback
    public function handleFacebookCallback(Request $request)
    {
        $facebookAppId = '650775210103068';
        $facebookAppSecret = 'bb6b4fd2931f77212fb2701aa5570808';
        $redirectUri = 'https://lifragrances.com/auth/facebook/callback';
        $scope = 'email';

        $fb = new Facebook([
            'app_id' => $facebookAppId,
            'app_secret' =>$facebookAppSecret,
            'default_graph_version' => 'v2.5', // Use the desired version
        ]);
        $helper = $fb->getRedirectLoginHelper();
        $accessToken = $helper->getAccessToken(route('facebook.callback'));
        print_r($helper);die;

        try {


            if (!$accessToken) {
                return redirect()->route('login')->with('error', 'Facebook authentication failed.');
            }

            $response = $fb->get('/me?fields=id,name,email', $accessToken);
            $userData = $response->getGraphUser();

            $facebookId = $userData->getId();
            $name = $userData->getName();
            $email = $userData->getEmail();

            // Now you can use $facebookId, $name, and $email to authenticate or create a user
            // ... your authentication and user creation logic ...

            return redirect('/dashboard'); // Redirect the user after successful login
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            // Handle API response errors
            return redirect()->route('login')->with('error', 'Facebook API error: ' . $e->getMessage());
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // Handle SDK related errors
            return redirect()->route('login')->with('error', 'Facebook SDK error: ' . $e->getMessage());
        }
    }
//
//    public function send_otp(Request $request){
//        $checkUser = User::where('mobile_number', $request->mobile)->first();
//
//        if ($checkUser != null) {
//            // User found
////
//            $senderid = 'Groovv';
//            $sendto = '7007680502';
//            $message = "Dear ".$checkUser->name." Your OTP for Logging in to Grooves account is ".rand(1111,9999)." Valid for 5 min - Grooveslifestyle";
//            $templateId = '1707170454023448070';
//
//            $sendotp = send_msg($senderid,$sendto,$message,$templateId);
//            print_r($sendotp);
//
//            return response(['code' => 200]);
//
//        } else {
//            // User not found
//            return response(['code' => 404]);
//        }
//        die;
//
//    }


    public function send_otp(Request $request) {

        $mobile = $request->mobile;
        \Session::put('otp_details',$mobile);

        $checkUser = User::where('mobile_number', $request->mobile)->first();

        if ($checkUser != null) {
            $otp = rand(1111,9999);
            $saveOtp = new Otp;
            $saveOtp->otp = $otp;
            $saveOtp->userid = $checkUser->id;
            $saveOtp->status = 0;
            $saveOtp->save();

            // API URL and API Key
            $destinationPhoneNumber = $mobile;
            $apiUrl = "https://api.gupshup.io/wa/api/v1/template/msg";
            $apiKey = "6449wdtgatngjnt2wu2zqd6upgtjsdkc";  // Replace with your actual API key
            $sourceNumber = "919795268402";  // Your Gupshup-provided source number
            $srcName = "vandanasaress";  // Your registered source name
//            $templateId = "0be33024-00de-4b2e-9600-8d9b1da932c9";  // Template ID

            // Prepare the POST data
            $postData = http_build_query(array(
                'channel' => 'whatsapp',
                'source' => $sourceNumber,
                'destination' => $destinationPhoneNumber,
                'src.name' => $srcName,
                'template' => json_encode(array(
//                    'id' => $templateId,
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
        } else {
            return response(['code' => 404]);
        }
    }

    public function verify_otp(Request $request) {

        if(\Session::has('otp_details')){
            $otp_number = \Session::get('otp_details');
        }

        $mobile = $request->mobile;
        $otp_number = $request->otp;

        $checkUser = User::where('mobile_number', $mobile)->first();
        if(!empty($checkUser)){

            $get_otp = Otp::where('userid',$checkUser->id)
                ->where('otp',$otp_number)
                ->orderBy('id','desc')
                ->first();

            if(!empty($get_otp)){
                $getUSer =  Auth::loginUsingId($checkUser->id); // Use Auth::login() instead of Auth::loginUsingId()
//                print_r($getUSer);die;
                return response(['code' => 200]);
            }else{
                return response(['code' => 404]);
            }

        }



        die;
        $mobile = $request->mobile;
        \Session::put('otp_details',$mobile);

        $checkUser = User::where('mobile_number', $request->mobile)->first();

        if ($checkUser != null) {

            $otp = rand(1111,9999);

            $saveOtp = new Otp;
            $saveOtp->otp = $otp;
            $saveOtp->userid = $checkUser->id;
            $saveOtp->status = 0;
            $saveOtp->save();

            $senderId = 'Groovv';
            $sendTo = '7007680502';
            $message = "Dear ".$checkUser->name." Your OTP for Logging in to Grooves account is ".$otp." Valid for 5 min - Grooveslifestyle";
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
        } else {
            return response(['code' => 404]);
        }
    }


    public function redirectTo() {
        $role = Auth::user()->role;
        switch ($role) {
            case '1':
                return '/admin/dashboard';
                break;
            case '2':
                return '/user-dashboard';
                break;

            default:
                return '/home';
                break;
        }
    }

    function login_page(){
        if(Auth::check()){
            if(Auth::user()->role == '1'){
                return view('web.login_page');
            }
        }else{
            return view('web.login_page');
        }
    }

    public function login(Request $request)
    {
//        print_r($request->all());die;
        $username = $request->email ?? $request->username; //the input field has name='username' in form
        $password = $request->password;

        if(filter_var($username, FILTER_VALIDATE_EMAIL)) {
            //user sent their email
//            echo 'e';
            Auth::attempt(['email' => $username, 'password' => $password]);
        } else {
            echo 'n';
            //they sent their username instead
            Auth::attempt(['username' => $username, 'password' => $password]);
        }
        if ( Auth::check() ) {
            return redirect(url('admin/dashboard'));
        }else{
            return redirect(url('login'));
        }

    }

    public function check_login(Request $request)
    {
//        print_r($request->all());die;
        $username = $request->email; //the input field has name='username' in form
        $password = $request->password;

        if(filter_var($username, FILTER_VALIDATE_EMAIL)) {
            //user sent their email
//            echo 'e';
            Auth::attempt(['email' => $username, 'password' => $password]);
        } else {
//            echo 'n';
//            die;
            //they sent their username instead
            Auth::attempt(['email' => $username, 'password' => $password]);
        }
        if ( Auth::check() ) {
//            echo "yes";
            if(Auth::user()->role == 2){
                return redirect(url('/'));
            }else{
                return redirect(url('/'));
            }

        }else{
//            echo "np";
            \Session::flash('error','Username or Password is incorrect');
            return redirect(url('login'));
        }

    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
