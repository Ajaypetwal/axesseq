<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Job;
use App\Models\Role;
use App\Models\User;
use App\Models\User\CreateJobs;
use App\Models\ApplyJob;
use App\Models\Follow;
use URL;

class JobsController extends Controller {
    public function createJob(Request $request) {
        $validator = Validator::make($request->all(), ['job_title' => 'required', 'company_name' => 'required', 'job_type' => 'required', 'address' => 'required', 'salary_range' => 'required', 'salary_period' => 'required', 'job_description' => 'required', 'qualification' => 'required', ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'code' => 404, 'message' => $validator->errors(), ], 404);
        }
        try {
            $user = $request->user();
            $userID = $user->_id; 
            $userName = $user->name;
            if ($user->role == 'Organization' || $user->role == 'Recruiter') {
                $job = Job::create(['role' => isset($user->role) ? $user->role : '', 'user_id' => $user->id, 'job_title' => isset($request->job_title) ? $request->job_title : '', 'company_name' => isset($request->company_name) ? $request->company_name : '', 'company_logo' => isset($request->company_logo) ? $request->company_logo : '', 'job_type' => isset($request->job_type) ? $request->job_type : '', 'salary_range' => isset($request->salary_range) ? $request->salary_range : '', 'salary_period' => isset($request->salary_period) ? $request->salary_period : '', 'address' => isset($request->address) ? $request->address : '', 'job_description' => isset($request->job_description) ? $request->job_description : '', 'qualification' => isset($request->qualification) ? $request->qualification : '', 'is_hide' => 0, ]);
               

            if ($job) {  
                 $userFollowID = Follow::where('follower_id',$userID)->pluck('user_id')->toArray();
                 if($userFollowID)
                 {
                   foreach($userFollowID as $foid){
                         $userDeviceToken = User::where('_id',$foid)->value('device_token');
                         if($userDeviceToken)
                         {
                             $userId = $foid;
                             $device_token= $userDeviceToken; 
                             $type="jobCreatedbyFollowed";
                             $title="Job created by followed person";
                             $Desription=  "Job created by " .$userName;
                             $sendNotification = sendPushNotification($request,$userId,$type,$title,$Desription, $device_token);
                         } 
                   }   
                 }

                    return response()->json(['success' => true, 'code' => 200, 'message' => 'Job created successfully', 'data' => $job], 200);
                } else {
                    return response()->json(['success' => false, 'code' => 404, 'message' => 'There is an issue while creating the job', ], 404);
                }
            } else {
                return response()->json(['success' => false, 'code' => 404, 'message' => 'Role not authorized to create job', ], 404);
            }
        }
        catch(Exception $e) {
            return response()->json(['success' => false, 'code' => 404, 'message' => $e->get_Message() ], 404);
        }
    }
    public function get_all_jobs(Request $request) {
        $user = $request->user();
        $userID = $user->id;
        $getjobsArr=[];
        $getRandJobsArr=[];
        $getjobs = Job::where('is_hide', '=', 0)->orderBy('_id', 'DESC')->get();
        $getrandjobs = Job::where('is_hide', '=', 0)->orderBy('_id', 'DESC')->get();
        if($getjobs){
            foreach($getjobs as $lst){ 
              $jobApplied= ApplyJob::where('user_id',$userID)->where('job_id',$lst->_id)->first();
                $getjobsArr[] = array( 
                    "role" => $lst->role,
                    "user_id"=> $lst->user_id,
                    "job_title"=> $lst->job_title,
                    "company_name" => $lst->company_name,
                    "company_logo"=> $lst->company_logo,
                    "job_type"=> $lst->job_type,
                    "salary_range"=> $lst->salary_range,
                    "salary_period"=> $lst->salary_period,
                    "address"=> $lst->address,
                    "job_description"=> $lst->job_description,
                    "qualification"=> $lst->qualification,
                    "is_hide"=>$lst->is_hide,
                    "updated_at"=> $lst->updated_at,
                    "created_at"=> $lst->created_at,
                    "_id" => $lst->_id,
                    "applyJob" => isset($jobApplied) ? true : false, 
                );
            }  
        }
            if($getrandjobs){
                foreach($getrandjobs as $lst){ 
                 $jobApplied= ApplyJob::where('user_id',$userID)->where('job_id',$lst->_id)->first();
                    $getRandJobsArr[] = array( 
                        "role" => $lst->role,
                        "user_id"=> $lst->user_id,
                        "job_title"=> $lst->job_title,
                        "company_name" => $lst->company_name,
                        "company_logo"=> $lst->company_logo,
                        "job_type"=> $lst->job_type,
                        "salary_range"=> $lst->salary_range,
                        "salary_period"=> $lst->salary_period,
                        "address"=> $lst->address,
                        "job_description"=> $lst->job_description,
                        "qualification"=> $lst->qualification,
                        "is_hide"=>$lst->is_hide,
                        "updated_at"=> $lst->updated_at,
                        "created_at"=> $lst->created_at,
                        "_id" => $lst->_id,
                        "applyJob" => isset($jobApplied) ? true : false, 
                    );
                }  
                return response()->json(['success' => true, 'code' => 200, 'message' => 'Jobs data', 'data' => ['Featured_Jobs' => $getjobsArr, 'Recommended_Jobs' => $getRandJobsArr]], 200);
  }
            
       
        else {
            return response()->json(['success' => false, 'code' => 404, 'message' => 'There is an issue while fetching the jobs', ], 404);
        }
    }
    public function job(Request $request, $id) {
        $JobID = Job::where('_id', '=', $id)->first();
        // return $JobID;
        try {
            if (($JobID)) {
                return response()->json(['success' => true, 'code' => 200, 'data' => $JobID, 'message' => 'Job Description']);
            } else {
                return response()->json(['success' => false, 'data' => '', 'message' => 'Job not found', 'code' => 404]);
            }
        }
        catch(Exception $e) {
            return response()->json(['success' => false, 'code' => 404, 'message' => 'Something went wrong'], 404);
        }
    }
    public function search_job(Request $request) {
        $validator = Validator::make($request->all(), ['job_title' => 'required', ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'code' => 404, 'message' => $validator->errors(), ], 404);
        }
        try {
            $job_title = $request->job_title;
            $job_type = $request->job_type;
            $Jobpost = Job::where('job_title', 'like', '%' . $job_title . '%')->orwhere('job_type', 'like', '%' . $job_type . '%')->get();
            // return $JobID;
            if (count($Jobpost) >= 1) {
                return response()->json(['success' => true, 'code' => 200, 'data' => $Jobpost, 'message' => 'Searched Results']);
            } else {
                return response()->json(['success' => false, 'data' => '', 'message' => 'Job not found', 'code' => 404]);
            }
        }
        catch(Exception $e) {
            return response()->json(['success' => false, 'code' => 404, 'message' => 'Something went wrong'], 404);
        }
    }
    public function user_create_jobs(Request $request) {
        $validator = Validator::make($request->all(), ['job_title' => 'required', 'company_name' => 'required', 'job_type' => 'required', 'address' => 'required', 'salary_range' => 'required', 'salary_period' => 'required', 'job_description' => 'required', 'qualification' => 'required', ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'code' => 404, 'message' => $validator->errors(), ], 404);
        }
        try {
            $user = $request->user();
            // return $user->id;
            if ($user->role == 'Organization' || $user->role == 'Recruiter') {
                $userjob = Job::create(['role' => isset($user->role) ? $user->role : '', 'user_id' => $user->id, 'job_title' => isset($request->job_title) ? $request->job_title : '', 'company_name' => isset($request->company_name) ? $request->company_name : '', 'company_logo' => isset($request->company_logo) ? $request->company_logo : '', 'job_type' => isset($request->job_type) ? $request->job_type : '', 'salary_range' => isset($request->salary_range) ? $request->salary_range : '', 'salary_period' => isset($request->salary_period) ? $request->salary_period : '', 'address' => isset($request->address) ? $request->address : '', 'job_description' => isset($request->job_description) ? $request->job_description : '', 'qualification' => isset($request->qualification) ? $request->qualification : '', 'is_hide' => 0, ]);
                // return $userjob;
                if ($userjob) {
                    return response()->json(['success' => true, 'code' => 200, 'message' => 'Job created successfully', 'data' => $userjob], 200);
                } else {
                    return response()->json(['success' => false, 'code' => 404, 'message' => 'There is an issue while creating the job', ], 404);
                }
            } else {
                return response()->json(['success' => false, 'code' => 404, 'message' => 'Role not authorized to create job', ], 404);
            }
        }
        catch(Exception $e) {
            return response()->json(['success' => false, 'code' => 404, 'message' => $e, ], 404);
        }
    }
    public function get_user_jobs(Request $request) {
        $user = $request->user();
        $userID = $user->id;
        try {
            $data = Job::where('user_id', $userID)->get();
            //return $data;
            if (count($data) > 0) {
                return response()->json(['success' => true, 'code' => 200, 'message' => 'Fetch User Jobs', 'data' => $data], 200);
            }
            return response()->json(['success' => false, 'code' => 404, 'message' => 'No jobs found', ], 404);
        }
        catch(Exception $e) {
            return response()->json(['success' => false, 'code' => 404, 'message' => 'Something went wrong'], 404);
        }
    }
    public function hide_user_jobs(Request $request) {
        $validator = Validator::make($request->all(), ['job_id' => 'required', ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'code' => 404, 'message' => $validator->errors(), ], 404);
        }
        try {
            $jobID = $request->job_id;
            $is_hide = $request->is_hide;
            $userid = Job::where('_id', $jobID)->first();
            if ((!$userid)) {
                return response()->json(['success' => false, 'code' => 404, 'message' => 'job ID is not valid', ], 404);
            }
            //$userhide = (isset($userid) == '1' ? '1' : '0');
            if ($userid) {
                $userid->is_hide = $is_hide;
                $userid->push();
                $userid->fresh();
            }
            if ($is_hide == 0) {
                return response()->json(['success' => true, 'code' => 200, 'data' => $is_hide, 'message' => 'Job post has been enabled']);
            }
            if ($is_hide == 1) {
                return response()->json(['success' => true, 'code' => 200, 'data' => $is_hide, 'message' => 'Job post has been disabled']);
            }
        }
        catch(Exception $e) {
            return response()->json(['success' => false, 'code' => 404, 'message' => $e->get_Message()], 404);
        }
    }
    public function apply_jobs(Request $request) {
      
        $validator = Validator::make($request->all(), ['job_id' => 'required', ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'code' => 404, 'message' => $validator->errors(), ], 404);
        }
        try {
              $user = $request->user();
             
            if ($user) {
                $userID=$user->id;
                $alreadyApplied= $request->job_id;
                $applier_userName = $user->name;
                $appliedJob = ApplyJob::where('job_id', $alreadyApplied)->where('user_id',$userID)->first();
                if(!empty($appliedJob))
                {
                    return response()->json(['success' => false, 'code' => 200, 'message' => 'You have already applied', 'data' => ''], 200);
                } 
                $JobData = Job::where('_id', $request->job_id)->first();
             if($JobData){
                 $jobUserID= $JobData->user_id;
                 $JobUserData = User::where('_id', $jobUserID)->first();
                 $userName= $JobUserData->name;
                 $device_token=$JobUserData->device_token;
             

                $is_checked = $request->is_checked;
                $upload_resume = $request->upload_resume;
                $cover_letter = $request->cover_letter; 
                //$userName= $user->name;
                //$device_token= $user->device_token;  
                  
                      
                            $applyjob = ApplyJob::create([
                                'user_id' => $userID, 
                                'job_id' => isset($request->job_id) ? $request->job_id : '', 
                                'is_checked' => ($request->is_checked== true) ? 1 : '0', 
                                'upload_resume' => isset($request->upload_resume) ? $request->upload_resume : '',
                                'cover_letter' => isset($request->cover_letter) ? $request->cover_letter : '',
                            ]); 

                    $postAppliedFor= $JobData->job_title;
                    $userAppliedResume=  URL::to('/').$applyjob->upload_resume;
                    $userAppliedCoverLetter = URL::to('/'). $applyjob->cover_letter;
                    $userIsChecked =  $applyjob->is_checked;
             
                    if($userIsChecked == 1)
                    { 
                        $type="Apply Job";
                        $title="User has apply job";
                        $Desription= $applier_userName . " has applied for Post ".' '.$postAppliedFor;
                        $sendNotification = sendPushNotification($request,$jobUserID,$type,$title,$Desription,$device_token);
                    }
                    else{  
                        $type="Apply Job";
                        $title="User has apply job";
                        $Desription= $applier_userName . " has applied for Post ".' '.$postAppliedFor .        $userAppliedResume;
                        $sendNotification = sendPushNotification($request,$jobUserID,$type,$title,$Desription,$device_token);
                    }  
                    return response()->json(['success' => true, 'code' => 200, 'message' => 'Successfully applied for job', 'data' => $applyjob], 200);

                        }
                        else{
                            return response()->json(['success' => false, 'code' => 200, 'message' => 'Job does not exsit', 'data' => ''], 200);
                        } 
            }
             else {
                return response()->json(['success' => false, 
                'code' => 404, 'message' => 'There is an issue while apply the job', ], 404);
            }
        
    }
        catch(Exception $e) {
            return response()->json(['success' => false, 'code' => 404, 'message' => $e->get_Message()], 404);
        }
    }



    public function deleteJob(Request $request) {
        $validator = Validator::make($request->all(), ['job_id' => 'required']);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'code' => 404, 'message' => $validator->errors(), ], 404);
        }
        try {
            $user = $request->user(); 
            $userID= $user->_id;
            if ($user->role == 'Organization' || $user->role == 'Recruiter') {
               
                $delete =  Job::where('_id', $request->job_id)->where('user_id',$userID)->delete();
                if($delete){
                    return response()->json(['success' => true, 'code' => 200, 'message' => 'Job deleted successfully', 'data' => $delete], 200);
            } else{
                return response()->json(['success' => false, 'code' => 404, 'message' =>'Error occured'], 404);
            }
        }
             else {
                return response()->json(['success' => false, 'code' => 404, 'message' => 'Role not authorized to delete job', ], 404);
            }
        }
        catch(Exception $e) {
            return response()->json(['success' => false, 'code' => 404, 'message' => $e->get_Message() ], 404);
        }
    }
}