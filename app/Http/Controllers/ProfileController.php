<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Profile;
use App\Models\WorkInfo;
use App\Models\User;
use App\Models\Certificate;
use App\Models\Follow;
use DB;
class ProfileController extends Controller {
    public function profile(Request $request) {
        try {
            $user = $request->user();
            $userID = $user->id;

            $followers= Follow::where('follower_id',$userID)->count();  
          $following = Follow::where('user_id',$userID)->count();   
          
            if ($user) {
                $user->profile_completion = 0;
                if ($user->name == "" || $user->email == "" || $user->phone_number == "" || $user->about_me == "" || $user->link_your_resume == "") {
                    $user->profile_completion+= empty($user->name) ? 0 : 10;
                    $user->profile_completion+= empty($user->email) ? 0 : 10;
                    $user->profile_completion+= empty($user->phone_number) ? 0 : 10;
                    $user->profile_completion+= empty($user->about_me) ? 0 : 10;
                    $user->profile_completion+= empty($user->link_your_resume) ? 0 : 10;
                    $user->profile_completion+= empty($user->cover_photo) ? 0 : 10;
                    $user->profile_completion+= empty($user->image) ? 0 : 10;
                } else {
                    $user->profile_completion+= 70;
                }
                // $user->profile_completion = 0;
                $user->save();
                $user->fresh();
            }
            $workinfo = WorkInfo::where('user_id', $userID)->first();
            if ($workinfo) {
                $workinfo->profile_completion = 0;
                if ($workinfo->your_role == "" || $workinfo->your_experience == "" || $workinfo->company_name == "") {
                    $user->profile_completion+= empty($workinfo->your_role) ? 0 : 10;
                    $user->profile_completion+= empty($workinfo->your_experience) ? 0 : 10;
                    $user->profile_completion+= empty($workinfo->company_name) ? 0 : 10;
                } else {
                    $user->profile_completion+= 30;
                }
                $user->save();
                $user->fresh();
            }
            $profile = User::where('_id', $userID)->with('work_info','profileSubscription', 'certificates')->first();
            if ($profile) {
                $profile['followers'] = $followers;    
                $profile['following'] = $following;   
                return response()->json(['success' => true, 'code' => 200, 'message' => 'Profile data', 'data' => $profile], 200);
            } else {
                return response()->json(['success' => false, 'code' => 404, 'message' => 'There is an error while fetching user data', ], 404);
            }
        }
        catch(Exception $e) {
            return response()->json(['success' => false, 'code' => 404, 'message' => $e, ], 404);
        }
    }
    public function edit(Request $request, $id) {
        $validator = Validator::make($request->all(), ['name' => 'required|string', ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'code' => 404, 'message' => $validator->errors(), ], 404);
        }
        $editprofile = User::where('_id', $id)->first();
        if (empty($editprofile)) {
            return response()->json(['success' => false, 'code' => 404, 'message' => 'User ID is not valid', ], 404);
        }
        try {
            $editprofile->image = isset($request->image) ? $request->image : $editprofile->image;
            $editprofile->name = isset($request->name) ? $request->name : '';
            $editprofile->email = isset($request->email) ? $request->email : '';
            $editprofile->phone_number = isset($request->phone_number) ? $request->phone_number : '';
            $editprofile->cover_photo = isset($request->cover_photo) ? $request->cover_photo : '';
            $editprofile->about_me = isset($request->about_me) ? $request->about_me : '';
            $editprofile->save();
            $token = $editprofile->createToken('authToken')->plainTextToken;
            $updated_work_info = isset($request->work_info) ? $request->work_info : [];
            if ($updated_work_info) {
                foreach ($updated_work_info as $data) {
                    $id = $data['id'];
                    //  if (isset($id))
                    if (!$id == '') {
                        if($id>=10000)
                        {
                        $workflowdated = ['your_role' => $data['your_role'], 'start_date' => $data['start_date'], 'end_date' => $data['end_date'], 'company_name' => $data['company_name'],'your_experience' => $data['your_experience'], ];
                        //  DB::table('workinfo')->where('_id',$id)->update($workflowdated);
                        $updatedworkinfo = WorkInfo::where('_id', $id)->update($workflowdated);
                    } else {

                        $workinfonew = new Workinfo;
                        $workinfonew->user_id = $editprofile->_id;
                        $workinfonew->image = isset($request->image) ? $request->image : '';
                        $workinfonew->your_role = isset($data['your_role']) ? $data['your_role'] : '';
                        $workinfonew->company_name = isset($data['company_name']) ? $data['company_name'] : '';
                        $workinfonew->start_date = isset($data['start_date']) ? $data['start_date'] : '';
                        $workinfonew->end_date = isset($data['end_date']) ? $data['end_date'] : '';
                        $workinfonew->your_experience = isset($data['your_experience']) ? $data['your_experience'] : '';
                        $workinfonew->save();

                        
                    }  

                          }else {
                        $workinfonew = new Workinfo;
                        $workinfonew->user_id = $editprofile->_id;
                        $workinfonew->image = isset($request->image) ? $request->image : '';
                        $workinfonew->your_role = isset($data['your_role']) ? $data['your_role'] : '';
                        $workinfonew->company_name = isset($data['company_name']) ? $data['company_name'] : '';
                        $workinfonew->start_date = isset($data['start_date']) ? $data['start_date'] : '';
                        $workinfonew->end_date = isset($data['end_date']) ? $data['end_date'] : '';
                        $workinfonew->your_experience = isset($data['your_experience']) ? $data['your_experience'] : '';
                        $workinfonew->save();
                    } 
                }
                
                $userName= $editprofile->name; 
               
                $userFollowID = Follow::where('follower_id',$editprofile->_id)->pluck('user_id')->toArray();
                if($userFollowID)
                {
                  foreach($userFollowID as $foid){
                        $userDeviceToken = User::where('_id',$foid)->value('device_token');
                        if($userDeviceToken)
                        {
    
                            $userId= $foid; 
                            $device_token= $userDeviceToken; 
                            $type="updateProfile";
                            $title=$userName . " has update profile";
                            $Desription=$userName . " has update profile";
                            $sendNotification = sendPushNotification($request,$userId,$type,$title,$Desription, $device_token);
                        } 
                  }   
                }
            }
            $certificate = isset($request->certificate) ? $request->certificate : [];
            if ($certificate) {
                foreach ($certificate as $value) {
                    $id = $value['id'];
                    //  if (isset($id))
                    if (!$id == '') {
                        $workflowdated = ['certificate_image' => $value['certificate_image'], 'title' => $value['title'], 'company_name' => $value['company_name'], 'start_date' => $value['start_date'], 'end_date' => $value['end_date'], ];
                        //  DB::table('workinfo')->where('_id',$id)->update($workflowdated);
                        $updatedworkinfo = Certificate::where('_id', $id)->update($workflowdated);
                    } else {
                        $Certificate = new Certificate;
                        $Certificate->user_id = $editprofile->_id;
                        $Certificate->certificate_image = isset($value['certificate_image']) ? $value['certificate_image'] : '';
                        $Certificate->title = isset($value['title']) ? $value['title'] : '';
                        $Certificate->company_name = isset($value['company_name']) ? $value['company_name'] : '';
                        $Certificate->start_date = isset($value['start_date']) ? $value['start_date'] : '';
                        $Certificate->end_date = isset($value['end_date']) ? $value['end_date'] : '';
                        $Certificate->save();
                        $Certificate->fresh();
                    }
                }
            }
            if ($request->link_your_resume) {
                $editprofile->link_your_resume = isset($request->link_your_resume) ? $request->link_your_resume : $editprofile->link_your_resume;
                $editprofile->save();
                $editprofile->fresh();
            }
             $editprofile->fresh();
             

            return response()->json(['success' => true, 'code' => 200, 'data' => '', 'message' => 'Profile Updated Successfully', 'access_token' => $token]);
        }
        catch(Exception $e) {
            return response()->json(['success' => false, 'code' => 404, 'message' => $e->getMessage(), ], 404);
        }
    }
}