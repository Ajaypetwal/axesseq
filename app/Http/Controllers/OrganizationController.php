<?php

namespace App\Http\Controllers;
use App\Models\Profile; 
use App\Models\WorkInfo; 
use App\Models\UserInfo; 
use App\Models\User; 
use App\Models\Company_Info; 
use Illuminate\Http\Request;
use App\Models\Follow;

class OrganizationController extends Controller
{
    public function Organizationprofile(Request $request){ 
      
        try { 
        $user =$request->user(); 
        $userID=  $user->id;   
      
        $followers= Follow::where('follower_id',$userID)->count();  
          $following = Follow::where('user_id',$userID)->count();  

       // $profile_basic = User::where('_id', $userID)->first();
       // $profile_user  = UserInfo::where('user_id', $userID)->get();
        $profile = User::where('_id', $userID)->with('userinfo','companyinfo')->first();
         $profile;

        if ($profile) {
            $profile['followers'] = $followers;    
            $profile['following'] = $following;   
            
        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'Origanisation Profile data',
            'data' => $profile
        ], 200); 
             } else { 

        return response()->json([
            'success' => false,
            'code' => 404,
            'message' => 'There is an error while fetching user data',
        ], 404);
    }
    }
    catch (Exception $e) {
        return response()->json([
            'success' => false,
            'code' => 404,
            'message' => $e,
        ], 404);
    }
    } 
    
    public function edit (Request $request,$id)
    { 
        
        $user =$request->user();  
        $editprofile = UserInfo::where('user_id',$id)->first(); 
       // return $editprofile;
        if (empty($editprofile)) {
        return response()->json([
            'success' => false,
            'code' => 404, 
            'message' => 'User ID is not valid',
        ], 404);
                } 
                try{  
                   $token = $user->createToken('authToken')->plainTextToken;  
                   // $token = $editprofile->createToken('authToken')->plainTextToken;  
                   $editprofile->company_name = isset($request->company_name) ?  $request->company_name : '';
                   $editprofile->company_email =isset($request->company_email) ?  $request->company_email : '';
                   $editprofile->company_phone = isset($request->company_phone) ?  $request->company_phone : '';
                   $editprofile->business_address = isset($request->business_address) ?  $request->business_address : '';
                   $editprofile->business_number = isset($request->business_number) ?  $request->business_number :'';
                   $editprofile->about_company = isset($request->about_company) ?  $request->about_company : '';
                   $editprofile->image = isset($request->image) ?  $request->image : '';
                   $editprofile->website = isset($request->website) ?  $request->website : '';
                   $editprofile->profile_pic = isset($request->profile_pic) ?  $request->profile_pic : '';
                   $editprofile->cover_pic = isset($request->cover_pic) ?  $request->cover_pic : '';
                   $editprofile->save(); 
                   


                    $companyinfo = Company_Info::where('user_id',$id)->first();
                    if(!$companyinfo){
                        $companyinfo = new Company_Info; 
                        $companyinfo->user_id = $user->_id;
                        $companyinfo->industry = isset($request->industry) ?  $request->industry : '';
                        $companyinfo->headquarters = isset($request->headquarters) ?  $request->headquarters : '';
                        $companyinfo->founded = isset($request->founded) ?  $request->founded : '';
                        $companyinfo->size_of_company = isset($request->size_of_company) ?  $request->size_of_company : '';                   
                        $companyinfo->save();                           
                    }  else{
                        $companyinfo->user_id = $user->_id;
                        $companyinfo->industry = isset($request->industry) ?  $request->industry : '';
                        $companyinfo->headquarters = isset($request->headquarters) ?  $request->headquarters : '';
                        $companyinfo->founded = isset($request->founded) ?  $request->founded : '';
                        $companyinfo->size_of_company = isset($request->size_of_company) ?  $request->size_of_company : '';                   
                        $companyinfo->save(); 
                    }                
                   
       
                      
                   $user->image = isset($request->image) ?  $request->image : $user->image;
                   $user->name = isset($request->name) ?  $request->name : $user->name;
                   $user->push();
                   $user->fresh();
                  

                   $device_token= $editprofile->device_token; 
                   $userFollowID = Follow::where('follower_id',$editprofile->_id)->pluck('follower_id')->first(); 
                   if($userFollowID)
                   {
                     $getUserData = User::where('_id',$userFollowID)->get();  
                     foreach($getUserData as $getUpdatedProfile)
                     {
                       $userName= $getUpdatedProfile->name;
                       $userId= $getUpdatedProfile->_id; 
                       // $device_token= $getUpdatedProfile->device_token; 
                       $type="updateProfile";
                       $title=$userName . " has update profile";
                       $Desription=$userName . " has update profile";
                       $sendNotification = sendPushNotification($request,$userId,$type,$title,$Desription, $device_token);
                     }
                   }

                    return response()->json(['success' => true, 'code' => 200, 'data' => $editprofile,
                     'message' => 'Profile Updated Successfully', 'access_token' => $token]);
         
                }
        catch (Exception $e) {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => $e,
            ], 404);
        }
    
}

}
