<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\sendEmail;
use Illuminate\Support\Facades\Hash;
use Exception;
use Twilio\Rest\Client;
use App\Models\User;
use App\Models\Role;
use App\Models\UserInfo;
use App\Models\WorkInfo;
use App\Models\Job;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Firebase\Auth\Token\Exception\InvalidToken;
use Kreait\Firebase\ServiceAccount;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Http;
use Guzzle\Http\Exception\ClientErrorResponseException;
use App\Models\TermsCondition;
use App\Models\Faq;
use App\Models\PrivacyPolicy;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $imageUrl = '';
        $data = [];
        $getemail = User::where('email', $request->email)->first();

        if (isset($request->is_create) && $request->is_create == true) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'role' => 'required|in:Professional,Recruiter,Organization'
            ]);
        } elseif ($request->from_social == true ) {
          
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'role' => 'required|in:Professional,Recruiter,Organization,Adminq@main'
            ]);
        }
        elseif (!empty($getemail) && $getemail->status == "inactive" ) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'role' => 'required|in:Professional,Recruiter,Organization,Adminq@main'
            ]);
        }
        else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                // 'phone_number'=>'required|max:14|unique:users,phone_number',
                'role' => 'required|in:Professional,Recruiter,Organization,Adminq@main'
            ]);
        }

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => $validator->errors(),
            ], 404);
        }

        try {
            // Check role
            $role = Role::where('name', $request->role)->first();

            if ($request->is_create == true) {
                if (empty($request->user_id)) {
                    return response()->json([
                        'success' =>  false,
                        'code' => 404,
                        'message' => 'User id is required while create a profile',
                    ], 404);
                }

                $user = User::where('_id', $request->user_id)->first();

                $userPhone  = isset($request->phone_number) ? $request->phone_number : $user->phone_number;
                $userEmail  = isset($request->email) ? $request->email : $user->email;
                $userName  =  isset($request->name) ? $request->name : $user->name;

                if ($user) {
                    $user->phone_number = $userPhone;
                    $user->email = $userEmail;
                    $user->name = $userName;
                    $user->save();
                } else {
                    return response()->json([
                        'success' =>  false,
                        'code' => 404,
                        'message' => 'No user found',
                    ], 404);
                }
            } else {
                $user = User::updateOrCreate([
                    '_id' => isset($getemail->id) ? $getemail->id : '',
                ],[
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => isset($request->password) ? Hash::make($request->password) : '',
                    'country_code' => $request->country_code,
                    'phone_number' => $request->phone_number,
                    'role' => $request->role,
                    'uid' => $request->uid == true ? $request->uid : '',
                    // 'uid' => $request->from_social == true ? $request->uid : '',
                    'provider' => $request->provider == true ? $request->provider : '',
                    'status'=>'inactive',
                    'device_token'=>isset($request->device_token) ? $request->device_token : '',
                ]);

            }
            if ($user) {
                $token = $user->createToken('authToken')->plainTextToken;
                $user->country_code = isset($request->country_code) ? $request->country_code : '';
                $user->role = isset($request->role) ? $request->role : '';
                if ($request->role == 'Organization' || $request->role == 'Recruiter') {
                    $UserInfo = $request->except('name', 'email', 'password', 'country_code', 'phone_number', 'role_id');
                    //$data['image'] = isset($request->image) ? $request->image : '';
                   // if ($request->image) {
                      //  $user->image = $request->image;
                      //  $user->save();
                       // $user->fresh();
                  //  }
                    // foreach ($data as $key => $value) {
                    //     $user_info = new UserInfo;
                    //     $user_info->user_id = $user->id;
                    //     $user_info->meta_key = $key;
                    //     $user_info->meta_value = $value;
                    //     $user_info->save();
                    // }
                   if($request->user_id) {
                        $UserInfo = UserInfo::create([
                            'user_id'=>$request->user_id,
                            'company_name' => $request->company_name,
                            'company_email' => $request->company_email,
                            'company_phone' => $request->company_phone,
                            'business_address' => $request->business_address,
                            'business_number' => $request->business_number,
                            'about_company' => $request->about_company,
                            'image' => $request->image,

                        ]);
                        $UserInfo->save();
                      $UserInfo->fresh();
                   }
                    return response()->json(['success' => true, 'code' => 200, 'data' => $user, 'message' => 'Register Successfully', 'access_token' => $token]);
                } elseif ($request->role == 'Professional') {
                   // $Workinfo = new Workinfo;
                    //$Workinfo->user_id = $user->id;
                   // $Workinfo->link_your_resume = isset($request->link_your_resume) ? $request->link_your_resume : '';
                   // $Workinfo->about_me = isset($request->about_me) ? $request->about_me : '';
                  //  $Workinfo->save();
                    $user->user_id = $user->id;
                    $user->link_your_resume = isset($request->link_your_resume) ? $request->link_your_resume : '';
                    $user->about_me = isset($request->about_me) ? $request->about_me : '';
                    $user->save();

                    $professionaldata = isset($request->work_info) ?  $request->work_info : [];

                    if ($request->work_info) {
                        foreach ($professionaldata as $value) {
                            $Workinfo = new Workinfo;
                            $Workinfo->user_id = $user->id;
                            $Workinfo->image = isset($request->image) ?  $request->image : '';
                            $Workinfo->your_role = isset($value['your_role']) ? $value['your_role'] : '';
                            $Workinfo->start_date = isset($value['start_date']) ? $value['start_date'] : '';
                            $Workinfo->end_date = isset($value['end_date']) ? $value['end_date'] : '';
                            $Workinfo->your_experience = isset($value['your_experience']) ? $value['your_experience'] : '';
                            $Workinfo->save();
                        }
                    }
                    if ($request->image) {
                        $user->image = $request->image;
                        $user->save();
                        $user->fresh();
                    }
                    $user->fresh(); 

                    return response()->json(['success' => true, 'code' => 200, 'data' => $user, 'message' => 'Register Successfully', 'access_token' => $token]);
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'success' =>  false,
                'code' => 404,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    public function login(Request $request)
    {
        $responseCode = 400;
        isset($request->user_admin) ? $responseCode = 200 : $responseCode = 400;
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => $validator->errors(),
            ], $responseCode);
        }
        try {
            
           $user = User::where('email', '=', $request->email)->first();

            if ($user) {
                if (!Hash::check($request->password, $user->password)) {
                    return response()->json(
                        [
                            'success' => false, 'error' => 'Password does not match.',
                            'code' => 404
                        ],
                        $responseCode
                    );
                }
            }
                else{
                    return response()->json(
                        [
                            'success' => false, 'error' => 'Email ID do not exitst',
                            'code' => 404
                        ],
                        $responseCode
                    );
                }
         $activeuser = User::where('email', $request->email)->where('status',"Active")->first();
            if($activeuser){

                if ($request->device_token) {
                    $user->device_token = $request->device_token;
                    $user->save();
                    $user->fresh();
                }

                $token = $user->createToken('authToken')->plainTextToken;
                return response()->json([
                    'access_token' => $token, 'success' => true, 'code' => 200, 'message' => 'successfully logged in', 'data' => $user, 'isVerification'=>'true',
                ]);
            } else {
                $token = $user->createToken('authToken')->plainTextToken;
                return response()->json([
                    'access_token' => $token,
                    'success' => true, 'message' => 'Please verify your profile',
                    'code' => 200,
                    'isVerification'=>'false',
                    'data'=>$user 
                ], 200);
            }
        }catch (Exception $e) {
            return response()->json([
                'success' =>  false,
                'code' => 404,
                'message' => 'Error: ' . $e->getMessage()
            ], $responseCode);
        }
    }

    public function twiliosendsms(Request $request)
    {
        $user = $request->user();
        $user_countrycode = $request->country_code;
        $user_phone = $request->phone_number;
        $receiverNumber = "+ $user_countrycode $user_phone";
       // $message = sprintf("%04d", mt_rand(1, 9999));
        $message="1234";
        try {
            // $account_sid = ("AC4b3f5dc2e5d19dbf2a7c07cf84d70271");
            // $auth_token = ("785beec4019796bd0d6223bc1a7d1ed2");
            // $twilio_number = ("+13184149606");
            // $client = new Client($account_sid, $auth_token);
            // $client->messages->create($receiverNumber, [
            //     'from' => $twilio_number,
            //     'body' => $message
            // ]);
            $userData = User::where('_id',$user->id)->first();

            if($userData){
                $userData->otp = $message;
                $userData->save();
                $userData->fresh();

                return response()->json([
                    'success' => true, 'code' => 200, 'message' => 'OTP Sent Successfully'
                ]);
            }
            else{
                return response()->json(['success' => false, 'code' => 404, 'message' => "User not found with the phone number"]);
            }

        } catch (Exception $e) {
            return response()->json(['success' => false, 'code' => 404, 'message' => "Error: " . $e->getMessage()]);
        }
    }

    public function verifyOTP(Request $request)
    {
        try {
            $user = $request->user();
            $user = User::where('_id',$user->id)->first();
            if (empty($user)) {
                return response()->json([
                    'success' => false,
                    'code' =>  404,
                    'message' => 'No OTP Matched'
                ], 404);
            }

            $userOtp = isset($user->otp) ? $user->otp : '';

           // if($request->otp == $userOtp){
            if($request->otp== "1234"){
                $user->status= "Active";
                $user->save();

                return response()->json(['success' => true, 'code' => 200, 'message' => 'OTP verified successfully']);
            }
            else {
                return response()->json(['success' => false, 'code' => 400, 'message' => 'OTP do not matched']);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'code' => 404, 'message' => "Error: " . $e->getMessage()]);
        }
    }

    public function resetpassword(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'email' => 'required',
            'phone_number' => 'required',
            'country_code' => 'required'

        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => $validator->errors(),
            ], 404);
        }
        try {
            $user = User::where('email', $request->email)->where('phone_number',$request->phone_number)->first();
            if (empty($user)) {
                return response()->json([
                    'success' => false,
                    'code' =>  400,
                    'message' => 'No user found'
                ], 404);
            }
            else{
                $token = $user->createToken('authToken')->plainTextToken;
                $user_countrycode = $request->country_code;
                $user_email = $request->email;
                $user_phone = $request->phone_number;
                $receiverNumber = "+$user_countrycode$user_phone";
               // $otp = sprintf("%04d", mt_rand(1, 9999));
                 $otp ="1234";
            //     $account_sid = ("AC4b3f5dc2e5d19dbf2a7c07cf84d70271");
            //    $auth_token = ("785beec4019796bd0d6223bc1a7d1ed2");
            //      $twilio_number = ("+13184149606");


            //     $client = new Client($account_sid, $auth_token);
            //     $client->messages->create($receiverNumber, [
            //         'from' => $twilio_number,
            //         'body' => $otp
            //     ]);

                if ($otp) {
                    $user->otp =  $otp;
                    $user->save();
                    $user->fresh();
                }
                return response()->json(['success' => true, 'code' => 200, 'message' => "Reset OTP sent", 'access_token' => $token], 200);
            }
        }
        catch (Exception $e) {
            dd("Error: " . $e->getMessage());
        }
    }

    public function changepassword(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'new_password' => 'required',
            'confirm_password' => 'required'

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => $validator->errors(),
            ], 404);
        }
        try {
            $user= $request->user();
            $new_password = $request->new_password;
            $confirm_password = $request->confirm_password;
            if ($new_password  !==  $confirm_password) {
                return response()->json([
                    'success' => false,
                    'code' => 404,
                    'message' => 'Password Do not Match',
                ], 404);
            }
            if ($new_password) {
                $user->password = Hash::make($new_password);
                $user->save();
                $user->fresh();

                return response()->json(['success' => true, 'code' => 200, 'message' => 'Password has been changed'], 200);
            } else {
                return response()->json(['success' => false, 'code' => 400, 'message' => 'There is an error while changing the password'], 400);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' =>  false,
                'code' => 404,
                'message' => 'Something went wrong'
            ], 404);
        }
    }

    // Social login with firebase
    public function socialLoginHandler(Request $request)
    {
         
        $validator = Validator::make($request->all(), [
            'firebase_token' => 'required',
            'role' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => $validator->errors(),
            ], 404);
        }
       
     $firebaseToken = $request->firebase_token;

        try {
            //init firebase
            $firebase = (new Firebase\Factory())->withServiceAccount(public_path('firebase.json'))
                ->withDatabaseUri('axxeseq-convrtx.firebaseapp.com');

           $auth = $firebase->createAuth();
          try {
                $verifiedIdToken = $auth->verifyIdToken($firebaseToken);
                
            } catch (Exception $e) {
              
                return response()->json([
                    'success' => false,
                    'code' => 404,
                    'message' => $e->getMessage(),
                ], 404);
            }

            $uid = $verifiedIdToken->claims()->get('sub');

           $user = $auth->getUser($uid);

            if ($user && !empty($user->providerData)) {
                $providerData = $user->providerData;
                $args = [
                    "email" => $providerData[0]->email,
                    "uid" => $providerData[0]->uid,
                    "provider" => $providerData[0]->providerId,
                //    'device_token'=>isset($request->device_token) ? $request->device_token : '',
                ];
                
                $checkUser = User::where($args)->first();

                if ($checkUser) {
                    $token = $checkUser->createToken('authToken')->plainTextToken;
                    return response()->json([
                        'success' => true,
                        'code' => 200,
                        'message' => "User already registered",
                        'data' => $checkUser,
                        'access_token' => $token,
                        'already_register' =>  true
                    ], 200);
                } else {
                    $role = Role::where('name', $request->role)->first();
                    if (!$role) {
                        return response()->json([
                            'success' => false,
                            'code' => 404,
                            'message' => 'No role found in the databse',
                        ], 404);
                    }

                    $socialData = array(
                        'name' => $providerData[0]->displayName,
                        'email' => $providerData[0]->email,
                        'uid' => $providerData[0]->uid,
                        'provider' => $providerData[0]->providerId
                    );
                    if ($socialData) {
                        return response()->json([
                            'success' => true,
                            'code' => 200,
                            'message' => "Data fetched successfully",
                            'data' => $socialData,
                            'already_register' =>  false
                        ], 200);
                    } else {
                        return response()->json([
                            'success' => false,
                            'code' => 404,
                            'message' => 'There is an issue while signup',
                        ], 404);
                    }
                }
            }
        } catch (Exception $e) {
            return 123;
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => $e->getMessage(),
            ], 404);
        }
    }


    public function check_email_exist(Request $request){
        try {

              $user = User::where('email', '=', $request->email)->first();
              if(empty($user))
              {
                return response()->json(['success' => true, 'code' => 200, 'is_email'=>false, 'message' => 'Email do not found']);
              }
              else{

              $userEmail= $user->email;
              $requestEmail=  $request->email;

            if($userEmail == $requestEmail){
                return response()->json(['success' => true, 'is_email'=>true, 'code' => 200, 'message' => 'Email already register']);
            }
             }

        } catch (Exception $e) {
            return response()->json(['success' => false, 'code' => 404, 'message' => "Email do not found"]);
        }

      }

      public function searchUserData(Request $request){ 

        $validator = Validator::make($request->all(), ['keyword' => 'required']);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'code' => 404, 'message' => $validator->errors(), ], 404);
        }
        try {
            $keyword = $request->keyword; 
            $userData = User::where('name', 'like', "%{$keyword}%")->orWhere('email', 'like', "%{$keyword}%")->get(); 
            // $userJobData = Job::where('job_title', 'like', '%' . $keyword . '%')->where('address', 'like', '%' . $keyword . '%')->where('job_type', 'like', '%' . $keyword . '%')->get(); 
            //$userSearchedData = $userData->merge($userJobData);   
            if ($userData) {
                return response()->json(['success' => true, 'code' => 200, 'data' => $userData, 'message' => 'User searched result']);
            } else {

                return response()->json(['success' => false, 'data' => '', 'message' => 'Data not found', 'code' => 404]);

            }
        }
        catch(Exception $e) {
            return response()->json(['success' => false, 'code' => 404,  'message' => $e->getMessage()], 404);
        }
      }
      
   public function linkedinauth(Request $request){
     
            $validator = Validator::make($request->all(), [
                'token' => 'required',
                'role' => 'required',
                'device_token'=>'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'code' => 404,
                    'message' => $validator->errors(),
                ], 404);
            }

        try{
                $client = new \GuzzleHttp\Client();
                $headers = [
                    'Authorization' => 'Bearer ' . $request->token,
                    'Accept'        => 'application/json',
                ];
        
            $responseData = $client->request('GET', 'https://api.linkedin.com/v2/emailAddress?q=members&projection=(elements*(handle~))', [
                'headers' => $headers
            ]);
            $responseDataEmail = $responseData->getBody()->getContents();
            
            $response = $client->request('GET', 'https://api.linkedin.com/v2/me?projection=(id,firstName,lastName,profilePicture(displayImage~:playableStreams))', [
                'headers' => $headers
            ]);
            $responseData = $response->getBody()->getContents();

            $myArrayEmail = json_decode(($responseDataEmail), true);
            $myArrayName = json_decode(($responseData), true);

            $firstName = $myArrayName['firstName']['localized']['en_US'];
            $lastName = $myArrayName['lastName']['localized']['en_US'];
            $Name = $firstName.' '.$lastName;
            $userEmail = $myArrayEmail['elements'][0]['handle~']['emailAddress'];
        
            $checkUser = User::where('email',$userEmail)->where('role',$request->role)->first();

            if ($checkUser) {

                $token = $checkUser->createToken('authToken')->plainTextToken;
                return response()->json([
                    'success' => true,
                    'code' => 200,
                    'message' => "User already registered",
                    'data' => $checkUser,
                    'access_token' => $token,
                    'already_register' =>  true
                ], 200);
            }else {

                $Data = array(
                    'name' => $Name,
                    'email' => $userEmail,
                    'provider' => "linkedin",
                );
                if ($Data) {
                    return response()->json([
                        'success' => true,
                        'code' => 200,
                        'message' => "",
                        'data' => $Data,
                        'already_register' =>  false
                    ], 200);
                } 
            }
        }
       catch (ClientErrorResponseException $exception) {
           $responseBody = $exception->getResponse()->getBody(true);
        }
   }

   public function term_condition(Request $request){
    try {
        $currentDateTime = Carbon::now();
        $currenDate = $currentDateTime->toDateTimeString();

       $data = TermsCondition::insert([
        'terms_condition' => $request->terms_condition,
        'description' => $request->description,
        'created_at' => $currenDate,
        'updated_at' => $currenDate
       ]);
       return response()->json(['success' => true, 'code' => 200,  'message' => $data], 200);
    }
    catch (Exception $e) {
        return response()->json(['success' => false, 'code' => 404,  'message' => $e->getMessage()], 404);
    }
   }
    // for faq //

    public function faq(Request $request){
      try {
        $currentDateTime = Carbon::now();
        $currenDate = $currentDateTime->toDateTimeString();

       $data = Faq::insert([
        'title' => $request->title,
        'description' => $request->description,
        'created_at' => $currenDate,
        'updated_at' => $currenDate
       ]);
       return response()->json(['success' => true, 'code' => 200,  'message' => $data], 200);
    }
    catch (Exception $e) {
        return response()->json(['success' => false, 'code' => 404,  'message' => $e->getMessage()], 404);
    }
   } 
   // for privacy-policy //

   public function privacy_policy(Request $request){
    try {
      $currentDateTime = Carbon::now();
      $currenDate = $currentDateTime->toDateTimeString();

     $data = PrivacyPolicy::insert([
      'privacy_policy' => $request->privacy_policy,
      'description' => $request->description,
      'created_at' => $currenDate,
      'updated_at' => $currenDate
     ]);
     return response()->json(['success' => true, 'code' => 200,  'message' => $data], 200);
  }
  catch (Exception $e) {
      return response()->json(['success' => false, 'code' => 404,  'message' => $e->getMessage()], 404);
  }
 } 

}
