<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
//    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//        $this->middleware('signed')->only('verify');
//        $this->middleware('throttle:6,1')->only('verify', 'resend');
//    }

//    public function resend(Request $request)
//    {
//        if ($request->user()->hasVerifiedEmail()) {
//            return redirect($this->redirectPath());
//        }
//
//        $request->user()->sendEmailVerificationNotification();
//
//        return back()->with('resent', true);
//    }

    function resend(){

        $token = \Str::random(64);

        $userid = Auth::user()->id;
        $useremail = Auth::user()->email;

        $emailVerification = new \App\Models\UserVerify;
        $emailVerification->userid	 =  $userid;
        $emailVerification->token = $token;
        $emailVerification->status = 0;
        $emailVerification->save();

        $email = $useremail;
//            print_r($email);die;
        \Mail::send('emails.UserVerification', ['token' => $token], function($message) use($email){
            $message->to($email ); // Use $request to get the email
            $message->subject('Email Verification sent');
        });

        return back()->with('verification_sent','Resent email sent');
    }



    function verifyAccount($token){
//        print_r($token);die;
        $verifyUser =  \App\Models\UserVerify::where('token', $token)->first();

        $user = User::find($verifyUser->userid);
        $message = 'Sorry your email cannot be identified.';
        if(!is_null($verifyUser) ){
            $user->status = '1';
            $user->save();
            \Session::flash('email_verified', 'success');
            return redirect(url('/'));
        }else{
            return redirect(url('/'))->with('email_not_verified', $message);
        }



    }
}
