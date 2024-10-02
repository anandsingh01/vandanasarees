<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

//    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */


//    protected $redirectTo = RouteServiceProvider::HOME;

    public function reset(Request $request)
    {
//        print_r($request->all());die;
        $token = $request->input('token');
        $email = $request->input('email');
        $password = $request->input('password');

        $user = DB::table('users')->where('email', $email)->first();
//        print_r($user);die;

//        if (!$user) {
////            return back()->with('error', 'User not found');
//            return "not";
//        }else{
//            return "found";
//        }

        $resetToken = DB::table('password_resets')->where('email', $email)
           ->first();

        if (!$resetToken) {
            return back()->with('error', 'User not found');
//            return "not";
        }

        DB::table('users')->where('email', $email)->update([
            'password' => Hash::make($password),
            'salt_password' => $password,
        ]);

        DB::table('password_resets')->where('email', $email)->delete();

        return redirect('/login')->with('success', 'Password reset successfully');
    }


    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }


    // Customize the redirect path after a successful password reset
    protected function redirectTo()
    {
        // Specify the URL where you want to redirect after successful reset
        return '/dashboard'; // Change this to the desired URL
    }

}
