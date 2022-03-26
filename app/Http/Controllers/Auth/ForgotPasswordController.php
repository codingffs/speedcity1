<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request; 
use DB; 
use Carbon\Carbon; 
use App\Models\User; 
use Mail; 
use Hash;
use Illuminate\Support\Str;


class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

     /**
       * Write code on Method
       *
       * @return response()
       */
      public function showForgetPasswordForm()
      {
         return view('auth.forgetPassword');
      }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitForgetPasswordForm(Request $request)
      {
          $request->validate([
              'email' => 'required|email|exists:users',
          ]);
  
          $token = Str::random(64);

          DB::table('password_resets')->where(['email'=> $request->email])->delete();

          DB::table('password_resets')->insert([
              'email' => $request->email, 
              'token' => $token, 
              'created_at' => Carbon::now()
            ]);

          $details = [
            'token' => $token,
        ];
        
            \Mail::to($request->email)->send(new \App\Mail\ForgetPasswordMail($details));
    
          return back()->with('success', 'We have e-mailed your password reset link!');
      }
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showResetPasswordForm($token) { 
        $password_resets = DB::table('password_resets')
        ->where(['token' => $token])->first();

        if(empty($password_resets)){
            return redirect('/login')->with('error', 'Token has been expired!');
        }
        return view('auth.forgetPasswordLink', ['token' => $token]);
      }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitResetPasswordForm(Request $request)
      {
          $request->validate([
              'password' => 'required|string|min:6|confirmed',
              'password_confirmation' => 'required'
          ]);
  
          $updatePassword = DB::table('password_resets')
                              ->where([
                                'token' => $request->token
                              ])
                              ->first();
           
          if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }
  
          $user = User::where('email', $updatePassword->email)
                      ->update(['password' => Hash::make($request->password)]);
 
          DB::table('password_resets')->where(['token'=> $updatePassword->token])->delete();
  
          return redirect('/login')->with('success', 'Your password has been changed!');
      }
}
