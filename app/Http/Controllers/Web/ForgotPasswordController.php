<?php
namespace App\Http\Controllers\Web;  
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request; 
use DB; 
use Carbon\Carbon; 
use App\Models\User; 
use App\Models\Admin; 
use Mail; 
use Hash;
use Illuminate\Support\Str;
  
class ForgotPasswordController extends Controller
{
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showForgetPasswordForm()
      {
         return view('admin.forget');
      }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitForgetPasswordForm(Request $request)
      {
        $validator = Validator::make($request->all(), [
          'email' => 'required',
      ]);
        
    
          if ($validator->fails()) { 
            return redirect()->route('forget.password.get')->withErrors($validator);
          //  <!--  return Redirect::to('forget.password.get')->withErrors($validator); 
         } 
        
          $token = Str::random(64);  
          $data = User::where('email',$request->email)->first();
          if(isset($data)){
                Mail::send('emails.forgetPassword', ['token' => $token], function($message) use($request){$message->to($request->email);
                $message->subject('Reset Password');
              });
               return redirect()->route('adminsignin')->with('message', 'We have e-mailed your password reset link!');
          }else{
              return back();
          }
      }
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showResetPasswordForm($token) { 
         return view('admin.resetpassowrd', ['token' => $token]);
      }
  
      /**
       * Write code on Method 
       *
       * @return response()
       */
      public function submitResetPasswordForm(Request $request)
      {
         
         $validator = Validator::make($request->all(),[
              'email' => 'required|email|unique:admins',
              'password' => 'required|string|min:4|confirmed',
              'password_confirmation' => 'required'
          ]);
        if($request->password != $request->password_confirmation){
          return back();
          // return redirect()->route('reset.password.get')->withErrors(['message'=>'please enter correct confirm password!']);
        }
       
        if($validator->fails()){
          return back();
       //   return redirect()->route('reset.password.post')->withErrors($validator);
        }
          // $updatePassword = DB::table('password_resets')
          //                     ->where([
          //                       'email' => $request->email, 
          //                       'token' => $request->token
          //                     ])->first();
          // return $updatePassword;
          // if(!$updatePassword){
          //     return back()->withInput()->with('error', 'Invalid token!');
          // }
          $data = User::where('email',$request->email)->first();
          if(isset($data)){
            User::where('role','Adminq@main')->update([
              'email'=> $request->email,
              'password'=> Hash::make($request->password),
              ]);
            // $user = Admin::where('username', $request->email)
           //             ->update(['password' => Hash::make($request->password)]);
          //return $user;
         //  DB::table('password_resets')->where(['email'=> $request->email])->delete();

            return redirect()->route('adminsignin')->with('message', 'Your password has been changed!');
          }else{
           // redirect()->back()->with('message', 'email id not exist!');
            return redirect('reset-password/{$request->token}')->with('message', 'email id not exist!');
          }
         
      }
}