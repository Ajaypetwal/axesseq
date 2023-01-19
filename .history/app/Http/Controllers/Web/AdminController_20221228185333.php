<?php

namespace App\Http\Controllers\Web;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use App\Models\Subscription;
use App\Models\User_Subscription;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;
use App\Models\AdminPushNotification;
use App\Models\PushNotification;
use App\Models\Profanity;
use App\Models\PrivacyPolicy;
use App\Models\Faq;
use App\Models\TermsCondition;
use App\Models\Event;
use App\Models\Push_card;
use App\Models\Job;
use App\Models\Admin;
use App\Models\Promotion;
use App\Models\UserInfo;
use App\Models\Company_Info;
use App\Models\WorkInfo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\{Support, User, Support_Message};
use DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        return view('admin/signin');
    }
    public function checkoutlogin(Request $request){
        

        $validator = Validator::make($request->all(), [
        'email' =>    'required',
        'password' => 'required',
      ]);
    //   if(Auth::user()){
    //     return redirect()->route('dashboard');
    //   }

       if(!$validator->passes()){
          return response()->json([
             'success'=> false,
             'error' => 'Invalid login details'
          ]);
        }
        $user = User::where('email',$request->email)->first();
        if($user && $user->role == "Adminq@main"){
            if (Hash::check($request->password, $user->password)) {
                // Session::put('somekey', 'somevalue');
                return response()->json([
                    'success' => true,
                    'message' => 'Logged in successfully!'
                ]);


            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Password'
                ]);
            }

        }else{
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ]);
        }


        return redirect("/");
    }

    public function dashboard()
    {
       
       $professional = User::where('role','Professional')->get();
       $recruiter =  User::where('role','Recruiter')->get();
       $organization = User::where('role','Organization')->get();
       $jobs = Job::all();
       $event = Event::all();
        return view("admin.dashboard")
                ->with(['professional'=>$professional,
                        'recruiter'=>$recruiter,
                        'organization'=>$organization,
                        'jobs'=>$jobs,
                        'event'=>$event,
                    ]);
    }
    public function multiple_image_upload(Request $request)
    {
    }
    public function support(Request $request)
    {

        $data = User::with('support')->get();

        // $supportdata = Support_Message::where('support_id', '=', $supportID)->where('user_id','=', $userID)
        // ->with('user:name,image')->get();
        // $finalResult = $data->merge($supportdata);


        $recruiterdata = [];
        $professionaldata = [];
        $organizationdata = [];
        $mainD = Support::with('user')->latest()->get();
        
        foreach ($mainD as $rd) {
           

            if ($rd->user->role == "Recruiter") {
                $countMessage_recru = Support_Message::Where('is_type',"User")->Where('support_id',$rd->_id)->where('read_unread','false')->count();
               
                $recruiterdata[] = array(
                    '_id' => $rd->_id,
                    'user_id' => $rd->user_id,
                    'ticket_number' => $rd->ticket_number,
                    'subject' => $rd->subject,
                    'message' => $rd->message,
                    'created_at' => $rd->created_at,
                    'user' => $rd->user,
                    'status' => $rd->status,
                    'userImage' => $this->getUserImage($rd->user_id, 'Recruiter'),
                    'countMessage_recru' => $countMessage_recru,
                );
            }
            if ($rd->user->role == "Professional") {
               
           $countMessage_pro = Support_Message::Where('is_type',"User")->Where('support_id',$rd->_id)->where('read_unread','false')->count();
        
            
                $professionaldata[] = array(
                    '_id' => $rd->_id,
                    'user_id' => $rd->user_id,
                    'ticket_number' => $rd->ticket_number,
                    'subject' => $rd->subject,
                    'message' => $rd->message,
                    'created_at' => $rd->created_at,
                    'user' => $rd->user,
                    'status' => $rd->status,
                    'countMessage_pro'=>$countMessage_pro,
                );
            }
            if ($rd->user->role == "Organization") {
                $countMessage_org = Support_Message::Where('is_type',"User")->Where('support_id',$rd->_id)->where('read_unread','false')->count();

                $organizationdata[] = array(
                    '_id' => $rd->_id,
                    'user_id' => $rd->user_id,
                    'ticket_number' => $rd->ticket_number,
                    'subject' => $rd->subject,
                    'message' => $rd->message,
                    'created_at' => $rd->created_at,
                    'user' => $rd->user,
                    'status' => $rd->status,
                    'userImage' => $this->getUserImage($rd->user_id, 'Organization'),
                    'countMessage_org' =>$countMessage_org,
                );
            }
        }

        // $professionaldata = Support::with('user','userinfo')->get();
        //    $professionaldata= json_decode($professionaldata);

        // $organizationdata = User::with('support')->get();
        // $organizationdata= [];//json_decode($organizationdata);
  
        return view("admin.support")->with(['recruiterdata' => $recruiterdata, 
        'professionaldata' => $professionaldata, 
        'organizationdata' => $organizationdata, 'data' => $data,
      
    ]);
    }

    public function completedUpdate(Request $request)
    {
        $response = [];

        $userID = $request->user_id;
        $support_id = $request->support_id;
        $updatedata = DB::table('supports')
            ->where('_id', '=', $support_id)
            ->update(['status' => 'completed']);

        if ($updatedata) {
            $response = [
                'success' => true,
                'message' => 'Ticket Status changed to Completed',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Something went wrong!',
            ];
        }
        return json_encode($response);
    }

    public function displayTicketMessage(Request $request){
        $userID = $request->user_id;
        $support_id = $request->support_id;
        $ticket_number = $request->ticket_number;
        $name = $request->name;
        $email = $request->email;
        $image = $request->image;
        $mediaWrapper = '';
        $messageMediaWrapper = '';
        $ticketStatus = Support::where('_id', $support_id)->get(['status']);
        $supportMessage = Support::where('_id', $support_id)->first();
        if(isset($supportMessage->upload_pic_video)){
            $mediaWrapper = $this->getSupportMediaWrapper($supportMessage->upload_pic_video);
        }
        $supportdata = Support_Message::where('support_id', $support_id)->where('user_id', $userID)->get();

        $messagetime = $supportMessage->created_at->diffForHumans();
        $createTime = date('d M Y',strtotime($supportMessage->created_at));
        if ($supportdata) {
            $htmlContennt = '';
            //first support message
            $htmlContennt .=  '<div class="mt-4">';
            $htmlContennt .=  '<p class="supp_chat_date"><span>' .$createTime.'</span></p>';
            $htmlContennt .=  '</div>';
            $htmlContennt .= '<div class="supp_chat_text_blue">';
            $htmlContennt .= '<div>';
            $htmlContennt .= '<img src="images/john1.png" alt="">';
            $htmlContennt .= '</div>';
            $htmlContennt .= '<div class="supp_chat_text_outer">';
            $htmlContennt .= '<div class="supp_chat_text_inner">';
            $htmlContennt .= '<p>'.$supportMessage->message.'</p>';
            $htmlContennt .= '</div>';
            $htmlContennt .= '<p>'.$messagetime.'</p>';
            $htmlContennt .= '</div>';
            $htmlContennt .= '</div>';
            $htmlContennt .= $mediaWrapper;

            $chatClass = '';
            $checkstatus = '';
            $supportImages = '';
            $dateCount = '';

       
            foreach ($supportdata as $sdata) {

                $messagetime = $sdata->created_at->diffForHumans();
                $created_at = $sdata->created_at;
                  $newDate =  date('d M Y',strtotime($created_at));
                $date = date('Y-m-d',strtotime($created_at));
                $today = Carbon::now();
                $todayDate = date('Y-m-d',strtotime($today));
                 
                 if($date == $todayDate){
                    $dateCount++;
                 }
               if (isset($sdata->is_type) && $sdata->is_type == 'Admin') {
                    $chatClass = 'supp_chat_text_grey';
                } else {
                    $chatClass = 'supp_chat_text_blue';
                }
                $htmlContennt .=  '<div class="mt-4">';
               if($dateCount == 1){
               $htmlContennt .=  '<p class="supp_chat_date"><span>' . $newDate . '</span></p>';
               }
              
                $htmlContennt .=  '</div>';
                $htmlContennt .= '<div class="' . $chatClass . '">';
                $htmlContennt .= $supportImages;
                if(!empty($sdata->message) && !empty($messagetime)) {
                $htmlContennt .= '<div class="supp_chat_text_outer">';
                $htmlContennt .= '<div class="supp_chat_text_inner">';
                $htmlContennt .= '<p>'.$sdata->message.'</p>'; 
                $htmlContennt .= '</div>';
                $htmlContennt .= '<p> ' . $messagetime . '</p>'; 
                $htmlContennt .= '</div>';
                }
                $htmlContennt .= '</div>';
                if( isset($sdata->upload_pic_video) && !empty($sdata->upload_pic_video) ){
                    $messageMediaWrapper = $this->getSupportMediaWrapper($sdata->upload_pic_video);
                    $htmlContennt .= $messageMediaWrapper;
                }
                // print_r($sdata);

            }
        }

        $response = array(
            'success' => true,
            'html' => $htmlContennt,
            'ticket_number' => $ticket_number,
            'name' => $name,
            'email' => $email,
            'userID' => $userID,
            'support_id' => $support_id,
            'image' => $image,
            'ticket_status' => $ticketStatus[0]->status
        );

        return json_encode($response);
    }
    public function createAdminMessage(Request $request)
    {
 
        $userID = $request->user_id;
        $messageMediaWrapper = '';

        $support_id = $request->support_id;
        $message = $request->message;
        $currentTime = Carbon::now();

        $gettime = $currentTime->toDateTimeString();

        $imageUrl = [];
        if ($request->hasFile('file')) {
            $getImage = $request->file;
            $imageName = time() . '.' . $getImage->extension();
            $imagePath = public_path() . '/images/' . $request->type;
            $imageUrl[] = '/images' . $request->type . '/' . time() . '.' . $getImage->extension();
            $getImage->move($imagePath, $imageName);
        }


        $data = array('user_id' => $userID, "support_id" => $support_id, "message" => $message, "created_at" => $gettime, "is_type" => "Admin", "upload_pic_video" => $imageUrl);

        $supportMessage = Support::where('_id', $support_id)->first();

        $adminMessage = DB::table('support__messages')->insert($data);

        if(isset($supportMessage->upload_pic_video)){
            $mediaWrapper = $this->getSupportMediaWrapper($supportMessage->upload_pic_video);
        }

        $supportdata = Support_Message::where('support_id', $support_id)->where('user_id', $userID)->get();

        $messageSeen = '';
        $messagetime = $supportMessage->created_at->diffForHumans();
        $createTime = date('d M Y',strtotime($supportMessage->created_at));
     
        if ($adminMessage) {
            $htmlContennt = '';
            //first support message
            $htmlContennt .=  '<div class="mt-4">';
            $htmlContennt .=  '<p class="supp_chat_date"><span>' . $createTime.'</span></p>';
            $htmlContennt .=  '</div>';
            $htmlContennt .= '<div class="supp_chat_text_blue">';
            $htmlContennt .= '<div>';
            $htmlContennt .= '<img src="images/john1.png" alt="">';
            $htmlContennt .= '</div>';
            $htmlContennt .= '<div class="supp_chat_text_outer">';
            $htmlContennt .= '<div class="supp_chat_text_inner">';
            $htmlContennt .= '<p>'.$supportMessage->message.'</p>';
            $htmlContennt .= '</div>';
            $htmlContennt .= '<p>'.$messagetime.'</p>';
            $htmlContennt .= '</div>';
            
            $htmlContennt .= '</div>';
            $htmlContennt .= $mediaWrapper;

            $chatClass = '';
            $checkstatus = '';
            $supportImages = '';
            $dateCount = '';
            foreach ($supportdata as $sdata) {
                $messagetime = $sdata->created_at->diffForHumans();
                $created_at = $sdata->created_at;
                $createTime = date('d M Y',strtotime($created_at));
                $date = date('Y-m-d',strtotime($created_at));
                $today = Carbon::now();
                $todayDate = date('Y-m-d',strtotime($today));
                 
                 if($date == $todayDate){
                    $dateCount++;
                 }

                if (isset($sdata->is_type) && $sdata->is_type == 'Admin') {
                    $chatClass = 'supp_chat_text_grey';
                } else {
                    $chatClass = 'supp_chat_text_blue';
                }
                $htmlContennt .=  '<div class="mt-4">';
                if($dateCount == 1 ){
                     $htmlContennt .=  '<p class="supp_chat_date"><span>' . $createTime . '</span></p>';
                }
                $htmlContennt .=  '</div>';
                $htmlContennt .= '<div class="' . $chatClass . '">';
                $htmlContennt .= $supportImages;
                if(!empty($sdata->message) && !empty($messagetime)){
                $htmlContennt .= '<div class="supp_chat_text_outer">';
                $htmlContennt .= '<div class="supp_chat_text_inner">';
                $htmlContennt .= '<p>' . $sdata->message . '</p>';
                $htmlContennt .= '</div>';
                $htmlContennt .= '<p> ' . $messagetime . '</p>';
                $htmlContennt .= '</div>';
                }
                $htmlContennt .= '</div>';
                if( isset($sdata->upload_pic_video) && !empty($sdata->upload_pic_video) ){
                    $messageMediaWrapper = $this->getSupportMediaWrapper($sdata->upload_pic_video);
                    $htmlContennt .= $messageMediaWrapper;
                }
            }

            $response = array(
                'success' => true,
                'html' => $htmlContennt
            );

            return json_encode($response);
        }
    }


    public function get_user_data(Request $request)
    {

        $recruiterdata = User::with('support', 'userinfo')->where('role', 'Recruiter')->get();
        return $recruiterdata = json_decode($recruiterdata);

        $professionaldata = User::with('support', 'userinfo')->where('role', 'Professional')->get();
        $organizationdata = User::with('support', 'userinfo')->where('role', 'Organization')->get();
        return view("admin.support")->with(['recruiterdata' => $recruiterdata, 'professionaldata' => $professionaldata, 'organizationdata' => $organizationdata]);
    }

    public function getUserImage($userId, $userType)
    {
        $image = '';
        if ($userType == 'Recruiter') {
            $image = UserInfo::where('user_id', $userId)->first();
            return  isset($image->image) ? $image->image : '';
        } else {
            return "";
        }
    }


    //create support media wrapper
    public function getSupportMediaWrapper($media){
        $mediaHtml = '';
        $chatOuterHtml = '';
        $chatSupHtml = '';
        if(!empty($media)){
            foreach($media as $md){
                $isImageCheck = $this->isImage($md);
                if($isImageCheck == true){
                    $chatOuterHtml .= '<div class="supp_chat_img_outer">';
                    $chatOuterHtml .= '<div class="supp_chat_img_main mr-3 mr-md-0">';
                    $chatOuterHtml .= '<img src="'.$md.'" alt="">';
                    $chatOuterHtml .= '</div>';
                    $chatOuterHtml .= '<div>';
                    $chatOuterHtml .= '<a href="'.$md.'" download="'.$md.'">';
                    $chatOuterHtml .= '<img src="images/CombinedShape.png" alt="" style="width: 13px;">';
                    $chatOuterHtml .= '</a>';
                    $chatOuterHtml .= '</div>';
                    $chatOuterHtml .= '</div>';
                }
                else{
                    $chatSupHtml .= '<div class="supp_chat_img_size">';
                    $chatSupHtml .= '<div>';
                    $chatSupHtml .= '<img src="images/supp_img.png" alt="">';
                    $chatSupHtml .= '</div>';
                    $chatSupHtml .= '<div class="supp_chat_img_text">';
                    $chatSupHtml .= '<h4>'.str_replace("/images/"," ",$md).'</h4>';
                    $chatSupHtml .= '<p>350 kb</p>';
                    $chatSupHtml .= '</div>';
                    $chatSupHtml .= '<div>';
                    $chatSupHtml .= '<a href="'.$md.'" download="'.$md.'">';
                    $chatSupHtml .= '<img src="images/arrow-bottom-right-r.png" alt="">';
                    $chatSupHtml .= '</a>';
                    $chatSupHtml .= '</div>';
                    $chatSupHtml .= '</div>';
                }
            }

            $mediaHtml .= '<div class="supp_chat_img">';
            //! outer
            $mediaHtml .= $chatOuterHtml;
            //! outer

            //! Sup
            $mediaHtml .= $chatSupHtml;
            //! Sup

            $mediaHtml .= '</div>';
        }

        return $mediaHtml;
    }

    public function isImage($image){
        $extension = pathinfo($image, PATHINFO_EXTENSION);
        $imgExtArr = ['jpg', 'jpeg', 'png','webp'];
        if(in_array($extension, $imgExtArr)){
            return true;
        }
        return false;
    }
    public function indexList(){

        $professionalAll = User::where('role','Professional')->get();
        $recruiterAll =  User::where('role','Recruiter')->get();
        $organizationAll = User::where('role','Organization')->get();



         $professional = User::where('role','Professional')->with('user_subscription')->paginate(5);
     //    dd($professional);
        //  $obj= array();
      // dd($professional);
    //    for($i=0;$i<=count($professional);$i++)
    //    {
    //      $id= $professional[$i]->user_subscription[0]->subscription_id  ?? '';
    //      $subscriptionID= explode(',',$id);
    //       ($type_obj =  Subscription::where('_id',$subscriptionID[0])->pluck('type')->toArray()); 
    //       foreach($type_obj as $obj)
    //       {
    //         $subID[]= explode(',',$obj);
    //       }
    //    }
        $proSub = array();
        $type_array_pro = array();
           
        foreach($professional as $value){
            
            foreach($value->user_subscription as $value) {
              $id =  $value->subscription_id;
             $type_obj =  Subscription::where('_id',$id)->get();
             foreach($type_obj as $value){
                 $proSub[] = $value->type;
             } 
         } 
         }

         $recruiter =  User::where('role','Recruiter')->with('user_subscription','userinfo')->paginate(5);
     
         $recSub = array();
         $type_array_rec = array();
      
    foreach($recruiter as $value){ 
       foreach($value->user_subscription as $value) {
               $id =  $value->subscription_id;
               $type_obj =  Subscription::where('_id',$id)->get();
                foreach($type_obj as $value){
                    $recSub[] = $value->type;
              } 
           } 
    
     }

     $organization = User::where('role','Organization')->with('userinfo')->with('user_subscription')->paginate(5);
       // return $organization;
       $orgSub = array();
       $type_array_org = array();
        foreach($organization as $value){
            foreach($value->user_subscription as $value) {
             $id =  $value->subscription_id;
             $type_obj =  Subscription::where('_id',$id)->get();
              foreach($type_obj as $value){
                $orgSub[] = $value->type;
            } 
         } 
        }

    return view("admin.professional")
                     ->with(['professinalAll'=>$professionalAll,
                            'recruiterAll'=>$recruiterAll,
                            'organizationAll'=>$organizationAll,
                            'professional'=>$professional,
                            'recruiter'=>$recruiter,
                            'organization'=>$organization,
                            'type_array_pro' =>$proSub,
                            'type_array_rec' =>$recSub,
                            'type_array_org' =>$orgSub,

                        ]);
    }
    public function searchbox(Request $request) {
        $role = $request->role;
        $search = $request->name;
  if($role == "Professional" || $role == "Recruiter"){
             
    $data = User::select("*")->where('role', $role)->with('user_subscription','userinfo')->get();
   
    // echo '<pre>';
    // return $data;
    // die();
    if(!empty($search) ){
        $data = User::select("*")->where('role', $role)->with('user_subscription','userinfo')->where(function($query) use ($search) {
            $query->where('name', 'LIKE', '%'.$search.'%')
                ->orWhere('email', 'LIKE', '%'.$search.'%');
        })->get();
    }

    $responseHtml = '';
    $activeClass = '';
    if($role == 'Professional'){
            $url = 'professional-profile';
    }else{
        $url = 'profile';        
    }
      $i= 0;
    if(isset($data) && count($data) > 0){
        foreach($data as $d){
            
            if($d->status == "Active"){
                $activeClass = 'checked';
            }else{
                $activeClass = '';
            }
   
           foreach($d->user_subscription as $value) {
                 $id =  $value->subscription_id;
                 $type_obj =  Subscription::where('_id',$id)->get();
                  foreach($type_obj as $value){
                    $orgSub[] = $value->type;
                } 
             } 
           
          if($role == "Professional"){
              $customer_img = URL('').$d->image;
          }else{
            if($d->userinfo){
                $image_arr = $d->userinfo->image;
                 $customer_img = URL('').'/'.$image_arr;
             }
          }
             

            $responseHtml .='<tr>';
            $responseHtml .='<td><img class="imageSize" src="'.$customer_img.'"> <span>'.$d->name.'</span></td>';
            $responseHtml .='<td>'.$d->email.'</td>';
            $responseHtml .='<td>'.'+'.$d->country_code.' '.substr($d->phone_number,0,3).' '.substr($d->phone_number,3,3).' '.substr($d->phone_number,6,4).'</td>';
            $responseHtml .='<td>'.date('d/m/Y',strtotime($d->updated_at)).'</td>';
            $responseHtml .='<td>';
            if(isset($orgSub[$i])){
                $responseHtml .= $orgSub[$i];
                  $i++;
                }else{
                    $responseHtml .='N/A';
                     }
                $responseHtml .='</td>';
            $responseHtml .='<td><label class="switch"><input type="checkbox" class="active_inactive" data-id="'.$d->_id.'" '.$activeClass.' data-check='.$activeClass.'><span class="sliderbtn round"></span></label></td>';
            $responseHtml .='<td><a href="/'.$url.'/'.$d->_id.'">show</a></td>';
            $responseHtml .= '</tr>';
        }
       
        return response()->json(['result' => $responseHtml,'status'=> "trueRes"]);
    }else{
        return response()->json(['result' => "Data not found",'status'=> false]);
    }

  }else {
   
     $data = User::where('role', $role)->with('userinfo')->with('user_subscription')->get();
     if(!empty($search)){

        $data = User::whereHas('userinfo', function($q) use($search){
                $q->where('company_name', 'LIKE', '%'.$search.'%')
                ->orWhere('company_email', 'LIKE', '%'.$search.'%');
        })->with('userinfo')->with('user_subscription')->get();                         
      }
    $responseHtml = '';
    $activeClass = '';
    if($role == 'Professional'){
            $url = 'professional-profile';
    }else{
        $url = 'profile';        
    }
   $i = 0;
    if(isset($data) && count($data) > 0){
        foreach($data as $d){
            if($d->status == "Active"){
                $activeClass = 'checked';
            }else{
                $activeClass = '';
            }

            foreach($d->user_subscription as $value) {
                $id =  $value->subscription_id;
                $type_obj =  Subscription::where('_id',$id)->get();
                 foreach($type_obj as $value){
                   $subID[] = $value->type;
               } 
            }    
            $company_img =  URL('').$d->userinfo->profile_pic;
            $responseHtml .='<tr>';
            $responseHtml .='<td>'.$d->userinfo->company_email.'</td>';
            $responseHtml .='<td><img class="imageSize" src="'.$company_img.'"> <span>';
            $responseHtml .=$d->userinfo->company_name.'</span></td>';
            $responseHtml .='<td>'.$d->userinfo->business_address.'</td>';
            $responseHtml .='<td>'.$d->userinfo->about_company.'</td>';
            $responseHtml .='<td>';
            if(isset($subID[$i])){
                $responseHtml .=$subID[$i];
                  $i++;
                }else{
                    $responseHtml .='N/A';
                     }
                $responseHtml .='</td>';


                $responseHtml .='<td><label class="switch"><input type="checkbox" class="active_inactive" '.$activeClass.' data-id="'.$d->_id.'"  data-check='.$activeClass.'><span class="sliderbtn round"></span></label></td>';
            $responseHtml .='<td><a href="/'.$url.'/'.$d->_id.'">show</a></td>';
            $responseHtml .= '</tr>';

        }
        return response()->json(['result' => $responseHtml,'status'=> "trueOrg"]);
    }else{
        return response()->json(['result' => "Data not found",'status'=> false]);
    }

     }

    }
  //-----code for download csv ----//
    public function exportFile(Request $request)
    {
        $role = $request->role;
        $search = $request->search;
        $fileName = 'tasks.csv';

        if($role == "Professional" || $role == "Recruiter"){
            $data = User::where('role',$role)->with('user_subscription')->get();   

            if(!empty($search) ){
                $data = User::select("*")->where('role', $role)->with('user_subscription','userinfo')->where(function($query) use ($search) {
                    $query->where('name', 'LIKE', '%'.$search.'%')
                        ->orWhere('email', 'LIKE', '%'.$search.'%');
                })->get();
            }

            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );
            
            $columns = array('Customer','Email','Phone Number','Account Created','Subscription Level','Active');

            $callback = function() use($data, $columns) {
            
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
                $i = 0;
                foreach ($data as $task) {
                    $subsType = "N/A";
                    $row['Customer']  = $task->name;
                    $row['Email']    = $task->email;
                    $row['Phone Number']   = $task->phone_number;
                    $row['Account Created']   = date('d/m/Y',strtotime($task->updated_at)); 
                    if(!empty( $task->user_subscription)){
                        if(isset($task->user_subscription[0]->subscription_id)){
                            $subsType = $this->getSubscriptionTypeById($task->user_subscription[0]->subscription_id);
                        }
                    }
                    else{
                        $subsType = "N/A";  
                    }
                    
                    $row['Subscription Level'] = $subsType;

                    $row['Active']  = isset($task->status)? $task->status:'N/A';

                    fputcsv($file, array($row['Customer'], $row['Email'],$row['Phone Number'], $row['Account Created'],$row['Subscription Level'], $row['Active']));
                }

                fclose($file);
            };

        }
        else {         
            $data = User::where('role',$role)->with('userinfo')->with('user_subscription')->get();

            if( !empty($search) ){
                $data = User::whereHas('userinfo', function($q) use($search){
                    $q->where('company_name', 'LIKE', '%'.$search.'%')
                    ->orWhere('company_email', 'LIKE', '%'.$search.'%');
            })->with('userinfo')->with('user_subscription')->get();    
            }
     
            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );
            
            $columns = array('Company Email','Company','Location','Description','Subscription Level','Active');

            $callback = function() use($data, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
                foreach ($data as $task) {
                    $subsType = "N/A";
                    $row['Company Email']  = isset($task->userinfo->company_email)? $task->userinfo->company_email:"N/A";
                    $row['Company']    = isset($task->userinfo->company_name) ? $task->userinfo->company_name:"N/A";
                    $row['Location']   = isset($task->userinfo->business_address) ? $task->userinfo->business_address:"N/A";
                    $row['Description']   = isset($task->userinfo->about_company)? $task->userinfo->about_company:"N/A";
                    
                    if(!empty( $task->user_subscription)){
                        if(isset($task->user_subscription[0]->subscription_id)){
                            $subsType = $this->getSubscriptionTypeById($task->user_subscription[0]->subscription_id);
                        }
                    }
                    else{
                        $subsType = "N/A";  
                    }
                    
                    $row['Subscription Level'] = $subsType;

                $row['Active']  = isset($task->status)? $task->status:'N/A';

                    fputcsv($file, array($row['Company Email'], $row['Company'],$row['Location'], $row['Description'],$row['Subscription Level'], $row['Active']));
                }

                fclose($file);
            };
        }

        return response()->stream($callback, 200, $headers);
    }
 //----- end of csv code -----//

    public function showPro($id = 0){
        $ProData = User::where('_id',$id)->with('work_info')->with('certificates')->first();
        return view('admin.professionalsDashboard')->with(['proData'=>$ProData]);
    }
   public function approveReject(Request $request){
    $success =  User::where('_id',$request->id)->update([
        'approval' =>$request->approve,
    ]);
    return  redirect()->route('indexList');
}
    public function showRecruOrg($id = 0){
      $recruOrgData = User::where('_id',$id)->with('companyinfo')->with('userinfo')->first();
      return view('admin.recruiterOrgDashboard')->with(['recruOrgData'=>$recruOrgData]);
    }
    public function advertisment(){
        $promoData = Promotion::where('approval',"0")->get();
        $promoApproved = Promotion::where('approval',"1")->get();
        $promoDenied = Promotion::where('approval',"2")->get();
        return view('admin.advertisment')->with(
                               ['promoData'=>$promoData,
                               'promoApproved'=>$promoApproved,
                               'promoDenied'=>$promoDenied
                            ]);
    }
    public function createAdvertisement(Request $request){
       return view('admin.createAdvertisement');
    }
    public function createAdvert(Request $request){
        $Validator = Validator::make($request->all(),[
            'file' =>'required', 
            'promotion_title' => 'required',
            'start_date'=> 'required',
            'end_date' => 'required',
            'amount' =>'required',
            'approval' => 'required',
            'description' =>'required',
        ]);
       $dataValid =  $Validator->validate();
            if($Validator->fails()){
                return Redirect::back()->withErrors($Validator)->withInput($Validator);
            }
        
            if($request->hasFile('file')){
                $getImage = $request->file;
                $imageName = time().'.'.$getImage->extension();
                $imagePath = public_path(). '/images/'.$request->type;
                $imageUrl = '/images'.$request->type.'/'.time().'.'.$getImage->extension(); 
                $getImage->move($imagePath, $imageName);
            }else {
               return back();
            }
            $currentDateTime = Carbon::now();
            $currenDate = $currentDateTime->toDateTimeString();
           $data =  Promotion::insert([
                   'image' =>$imageName,
                   'promotion_title' =>$request->promotion_title,
                   'start_date' =>$request->start_date,
                   'end_date' =>$request->end_date,
                   'amount' =>$request->amount,
                   'approval' =>$request->approval,
                   'description' =>$request->description,
                   'created_at' =>$currenDate,

            ]); 
            return redirect('advertisment');    
    }


    public function postApproval(Request $request){
        $id = $request->id;
        $value = $request->value;
        if($value == 1){
            $approvepost =  Promotion::where('_id',$id)->update(array('approval' => $value));
            if(isset($approvepost)){
               return response()->json(["message"=>"Approval approved successfull","status"=>true]);
            }else {
               return response()->json(["message"=>"oops! something went wrong","status"=>false]);
            }
        }else{
            $approvepost =  Promotion::where('_id',$id)->update(array('approval' => $value));
            if(isset($approvepost)){
                return response()->json(["message"=>"Approval denied successfull","status"=>true]);
             }else {
                return response()->json(["message"=>"oops! something went wrong","status"=>false]);
             }
        }

    }
    // -----------------show cards dashboard ---------- //
    public function pushCardDash(){
        $data = Push_card::get();
        return view('admin.push_card')->with(['data'=>$data]); 
    }
    // ----------create push card --------------//
    


      public function pushCard(){
          return view('admin.createPushCard');
    }
    public function addPushCard(Request $request){
        $Validator = Validator::make($request->all(),[
            'file' =>'required', 
            'title' => 'required',
            'date'=> 'required',
            'description' => 'required',
        ]);
       $dataValid =  $Validator->validate();
            if($Validator->fails()){
                return Redirect::back()->withErrors($Validator)->withInput($Validator);
            }
        
            if($request->hasFile('file')){
                $getImage = $request->file;
                $imageName = time().'.'.$getImage->extension();
                $imagePath = public_path(). '/images/'.$request->type;
                $imageUrl = '/images'.$request->type.'/'.time().'.'.$getImage->extension(); 
                $getImage->move($imagePath, $imageName);
            }else {
               return back();
            }
            $currentDateTime = Carbon::now();
            $currenDate = $currentDateTime->toDateTimeString();

           $data =  Push_card::insert([
                   'image' =>$imageName,
                   'title' =>$request->title,
                   'date' =>$request->date,
                   'description' =>$request->description,
                   'updated_at' => $currenDate,

            ]);
            if(isset($data)){
                $message = 'card created successfully';
                Session::flash('message',$message);
                return redirect()->route('pushCardDash');  
            }else {
                $error = '!oops card not created ';
                Session::flash('message',$error);
                return redirect()->route('pushCardDash');  
            }
            
    }
    // --------  edit push-card ----------------- //
    public function editPushCard($id){
            $data =  Push_card::find($id);
           if($data){
              return view('admin.push_card_edit')->with(['data'=>$data]);
            }else {
                return back();
            }
        
    }
    public function editCard(Request $request){
      
        $id = $request->id;
        $Validator = Validator::make($request->all(),[
            'file' =>'required', 
            'title' => 'required',
            'date'=> 'required',
            'description' => 'required',
        ]);
       $dataValid =  $Validator->validate();
            if($Validator->fails()){
                return Redirect::back()->withErrors($dataValid)->withInput($dataValid);
            }
            if ($request->file) {
                $getImage = $request->file;
                $imageName = time() . '.' . $getImage->extension();
                $imagePath = public_path() . '/images/' . $request->type;
                $imageUrl[] = '/images' . $request->type . '/' . time() . '.' . $getImage->extension();
                $getImage->move($imagePath, $imageName);
          
            }else {
               return back();
            }
  
           $data =  Push_card::where('_id',$id)->update([
            'image' =>$imageName,
            'title' =>$request->title,
            'date' =>$request->date,
            'description' =>$request->description,
         ]);

     if(isset($data)){
         $message = 'card edit successfully';
         session()->flash('message',$message);
         return redirect()->route('pushCardDash');  
     }else {
         $error = '!oops card not edit ';
         session()->flash('message',$error);
         return redirect()->route('pushCardDash');  
     }
      
    }

    public function deletePush($id){
              $data = Push_card::find($id);
              if($data){
                $success =  $data->delete();
                $message = "card deleted successfully";
                session()->flash('message',$message);
                return redirect()->route('pushCardDash');  
              }else{
                $error = "!oops card not deleted ";
                session()->flash('message',$error);
                return redirect()->route('pushCardDash');
              }

    }
    // -----------for guideLine ----------------//

    public function guideLineTerm(){
     
      $guideTerm = TermsCondition::first();
      $guide_Faq = Faq::latest('updated_at')->first();
      $guidePrivay_policy = PrivacyPolicy::first();
      $guideProfanity = Profanity::first();

        return  view('admin.guideLineTerm')->with(['guideTerm'=>$guideTerm,
         'guide_Faq'=>$guide_Faq,'guidePrivay_policy'=>$guidePrivay_policy,
         'guideProfanity'=>$guideProfanity]);
    }
    public function guidLine(Request $request){
            $term= $request->term;
            if($term == "TermsCondition" || $term == "PrivacyPolicy"){
                if($term == "TermsCondition"){
                    $desdata = TermsCondition::first();
                    if(!empty($desdata)){
                      
                     }else{
                        return back();
                     }
                }else{
                    $desdata = PrivacyPolicy::first();
                    if(!empty($desdata)){
                      
                    }else{
                       return back();
                    }
                }
                $ad = '';
                $sidedes = '';
                
                    $ad .='<p>';
                    $ad .=$desdata->description;
                    $ad .='</p>';

                    // $sidedes .='<div class="logs">';
                    // $sidedes .='<h3>'.date('M d, Y',strtotime($desdata->created_at)).'</h3>';
                    // $sidedes .='<h5>Update Logs</h5>';
                    // $sidedes .='<ul class="logs-date">';
                    // $sidedes .='<li>'.date('m/d/Y',strtotime($desdata->updated_at)).'</li>';
                    // $sidedes .='<li>Term &amp; Conditions - Updated!</li>';
                    // $sidedes .='<li>'.date('m/d/Y',strtotime($desdata->updated_at)).'</li>';
                    // $sidedes .='<li>FAQ</li>';
                    // $sidedes .='</ul>';
                    // $sidedes .='</div>';
                    if($term == "TermsCondition"){
                        return response()->json(['result' => $ad,'sidedes'=>'','status' => "TermsCondition"]);
                        }else{
                            return response()->json(['result' => $ad,'sidedes'=>$sidedes,'status' => "PrivacyPolicy"]);
                        }
              
            }else if($term == "FAQ"){

                $faq = Faq::get();
                $faqhtml = '';
                $count = 0;
              
                foreach($faq as $value){
                    $count++;
                    $faqhtml .='<div class="panel panel-default">';
                    $faqhtml .='<div class="panel-heading" role="tab" id="headingOne">';
                    $faqhtml .='<div class="row">';
                    $faqhtml .='<div class="col-lg-10 col-md-10">';
                    $faqhtml .='<h4 class="panel-title">';
                    $faqhtml .='<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne'.$count.'" aria-expanded="true" aria-controls="collapseOne">';
                    $faqhtml .=$value->title;
                    $faqhtml .='</a></h4>';
                    $faqhtml .='</div>';
                    $faqhtml .='<div class="col-lg-2 col-md-2">';
                    $faqhtml .='<a href="/editFaq/'.$value->_id.'"><img src="admin/images/cardedit.svg" alt="edit"></a></div>';
                    $faqhtml .='</div>';
                    $faqhtml .='</div>';
                    $faqhtml .='<div id="collapseOne'.$count.'" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">';
                    $faqhtml .='<div class="panel-body">';
                    $faqhtml .=$value->description;
                    $faqhtml .='</div></div></div>';
                  

                }
                return response()->json(['result' => $faqhtml,'status' => 'faq']);
            }else if($term == "Profanity"){
                   
                    $profanity = Profanity::all();
                    $proHtml = '';
                    $areaHtml = '';
                    
                    $proHtml .='<div id="Profanity" class="size_chart mt-5">';
                    $proHtml .='<form>';
                    $proHtml .='<div class="form-row"><div class="form-group col-md-7">';
                    $proHtml .='<input type="text" class="form-control inputfield" name="title" id="inputtext" placeholder="Profanity"></div>';
                    $proHtml .='<div class="form-group col-md-5"><div class="btn-guide-blue-ouline text-right">';
                    $proHtml .='<a href="#" class="guideline-btn guide-btn-blue-outline addmore">Add More</a>';
                    $proHtml .='</div></div></div></form></div>';
                    $count = 0;
                 foreach($profanity as $value){
                    $count++;
                    $areaHtml .='<div class="profanity_tag profanity_era'.$count.' pro_area">';
                    $areaHtml .='<p>'.$value->title_btn.'</p><button class="cancelbtn" data-val="'.$value->_id.'">';
                    $areaHtml .='<img  src="admin/images/crossgrey.png" alt="">';
                    $areaHtml .='</button></div>';

                 }

          
                return response()->json(['result' => $proHtml,'areaHtml'=>$areaHtml,'status' => 'Profanity']);
 
 }
           
    }
    public function editTermCon(Request $request){
       
            $data = TermsCondition::where('terms_condition','TermsCondition')->first();
           if(!empty ($data)) {
                return view('admin.edit_term_condition')->with(['data'=>$data]);    
           }else {
                return back();
           }
           
    }
    public function editTerm(Request $request){
        $currentDateTime = Carbon::now();
        $currenDate = $currentDateTime->toDateTimeString();

        $Validator = Validator::make($request->all(),[
            'description' =>'required', 
          ]);
       $dataValid =  $Validator->validate();
            if($Validator->fails()){
                return Redirect::back()->withErrors($Validator)->withInput($Validator);
            }
 
          $data =  TermsCondition::where('terms_condition',"TermsCondition")->update([
                'description'=> $request->description,
                'updated_at' => $currenDate,
             ]);
          return redirect()->route('guideLineTerm');

    }
    public function editFaq($id=0){
        $data = Faq::where('_id',$id)->first();
       
        return view('admin.edit_faq')->with(['data'=>$data]);
    }
    public function edit_faq(Request $request){
        $Validator = Validator::make($request->all(),[
            'title' =>'required', 
            'description' =>'required', 
          ]);
       $dataValid =  $Validator->validate();
            if($Validator->fails()){
                return Redirect::back()->withErrors($Validator)->withInput($Validator);
            }
       
          $data =  Faq::where('_id',$request->id)->update([
                'title'=> $request->title,
                'description'=> $request->description,
             ]);
          return redirect()->route('guideLineTerm');
    }
    public function privacyPolicy(){
        $data = PrivacyPolicy::where('privacy_policy','PrivacyPolicy')->first();
        return view('admin.privacy_policy')->with(['data'=>$data]);
    }
    public function editPrivacy(Request $request){
        $Validator = Validator::make($request->all(),[
            'description' =>'required', 
            ]);
          $dataValid =  $Validator->validate();
            if($Validator->fails()){
                return Redirect::back()->withErrors($Validator)->withInput($Validator);
            }
 
          $data =  PrivacyPolicy::where('privacy_policy',"PrivacyPolicy")->update([
                'description'=> $request->description,
             ]);
          return redirect()->route('guideLineTerm');
    }

    public function capProfanity(Request $request){

            $data = $request->value;
            $currentTime = Carbon::now();
           $gettime = $currentTime->toDateTimeString();
           $indata = Profanity::insert([
                'profanity' => 'Profanity ',
                'title_btn' => $data,
                'created_at'=>$gettime,
                'updated_at'=>$gettime,
            ]);
           $id = Profanity::where('title_btn',$data)->first();
            $areaHtml = '';
            $areaHtml .='<div class="profanity_tag profanity_era pre_area">';
            $areaHtml .='<p>'.$data.'</p><button class="cancelbtn" data-val="'.$id->_id.'">';
            $areaHtml .='<img src="admin/images/crossgrey.png" alt="">';
            $areaHtml .='</button></div>';

        return response()->json(['result'=>$areaHtml,'status' => 'true']);
    }
    public function deletePro(Request $request){
          $id = $request->value;
         $data = Profanity::find($id);
         $user = Profanity::where('_id',$id)->delete();
       if($user){
            return response()->json(['status' => 'true']);
         }
     }
    public function adminPushNotification(){
            $hitory_date = AdminPushNotification::where('history',true)->get();
           return view('admin.adminPushNotification',['hitory_date'=>$hitory_date]);
    }

    public function pushNotificationGroup(){
         
        $currentTime = Carbon::now();
        $gettime = $currentTime->toDateTimeString();
        $date = date('Y-m-d', strtotime($gettime));
       
        $old_data = AdminPushNotification::where('date',$date)->get();
        
     foreach($old_data as $value){
       
      
        // dd($image);
        if($value->date == $date){
            $role = $value->type;       
            $role = explode (",", $role); 
           
            if($role){
              $getAllUserRole =User::WhereIn('role',$role)->pluck('device_token')->toArray();
            }
            // return  $getAllUserRole;
            $image = URL('').'/images/'.$value->file;
        
            $url = 'https://fcm.googleapis.com/fcm/send';
            $serverKey = 'AAAA39y8o54:APA91bFjwHKf_vKoueVd8uERUL7juG4GnB966-ZxIzeYNRYDOaGAve1n347MNLBaMcroh0MrpimIO27hcpFhWSgg_L0QJ72Hk3Hbdy2m0oFMgs-8gOuf8Yqkke1lap7Ij8BnjJrjq3wE';
            for($i=0; $i < count($getAllUserRole) ; $i++)
            {
            
                $device_token= $getAllUserRole[$i]; 
                $data = [
                    "to" =>$device_token, 
                    "priority"  => "high",
                    "collapse_key" => "type_a",
                    "notification" =>
                        [
                           "body" => $value->description,
                            "title" => $value->title,
                            "image" => $image,
                            'style' => 'picture',
                            "picture" => $image,
                            "vibrate"   => 1,
                            "sound"     => 1
                            // 'media' =>$image,
                        ],
                        "data" =>
                        [
                           "body" => $value->description,
                            "title" => $value->title,
                            "image" => $image,
                            'style' => 'picture',
                            "picture" => $image,
                            "vibrate"   => 1,
                            "sound"     => 1
                            // 'media' =>$image,
                        ] ,
                      
                ]; 

               $encodedData = json_encode($data); 
               $headers = [
                   'Authorization:key=' . $serverKey,
                   'Content-Type: application/json',
               ];
           
               $ch = curl_init(); 
               curl_setopt($ch, CURLOPT_URL, $url);
               curl_setopt($ch, CURLOPT_POST, true);
               curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
               curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
               curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
               curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
               // Disabling SSL Certificate support temporarly
               curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
               curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
               // Execute post
              
               $result = curl_exec($ch);
               // FCM response
               if($result)
               {
                Log::debug('Web push notification send');
                $success =  AdminPushNotification::where('_id',$value->_id)->update(["history"=>true]);
                print_r('G');
                
               }
            }
         }
    }
//    return redirect()->route('adminPushNotification');
}
  

   public function  adminPushNoti(Request $request){
  
           $validate = $request->validate([
                            'type1' =>'required',
                            'date' =>'required',
                            'title' =>'required',
                            // 'toall' => 'required',
                            'description' => 'required',
                          //  "file"=>'required|image|mimes:jpg,png,jpeg,gif,svg',
                ]);
               
            if($validate){
            if($request->hasFile('file')){
            
                // if($request->hasFile('image')){
                // $validate = $request->validate([
                //         'image' =>'required|image|mimes:jpg,png,jpeg,gif,svg',
                //     ]);
                //         if($validate){ 
                //             $getImage = $request->image;
                //             $fileName = time().'.'.$getImage->extension();
                //             $imagePath = public_path(). '/images/'.$request->type;
                //             $imageUrl = '/images'.$request->type.'/'.time().'.'.$getImage->extension(); 
                //             $getImage->move($imagePath, $fileName);
                //             $fileName='';
                //         }else{
                //             return back();
                //         }
                //  }
                if($request->hasFile('file')){
                    $getImage = $request->file;
                    $fileName = time().'.'.$getImage->extension();
                    $imagePath = public_path(). '/images/'.$request->type;
                    $imageUrl = '/images'.$request->type.'/'.time().'.'.$getImage->extension(); 
                    $getImage->move($imagePath, $fileName);
                    $imageName ='';
                }else{ 
                    return back();}
            }else {
            return back();
            }
           $checkbox = json_encode($request->checkbox);
            $data = AdminPushNotification::insert([
                    'type' => $request->type1[0],
                    'date'=>$request->date,
                    'title' =>$request->title,
                    // 'toall' =>$request->toall,
                    'file' =>$fileName,
                    'history' =>false,
                    'description' =>$request->description,
                ]);
              
     return redirect()->route('adminPushNotification');
            }else {
                return back();
              };
   
    }

    public function checkNoti(Request $request){
        $role = $request->role;
        $check =  $request->checked;
        $all_token = array();
      
       if($role == "sendtoall"){
            if(empty($check)){
                return response()->json(['result' => '','status'=> "sendtoall"]);
             }else{
                $alluser = User::get();
                foreach($alluser as $value){
                    $all_token[] = $value->device_token;
                 };
                return response()->json(['result' => $all_token,'status'=> "sendtoall"]);
             }
        }else if($role == "Professional"){
            if(empty($check)){
                return response()->json(['result' => '','status'=> "Professional"]);
             }else{
                $alluser = User::where('role',$role)->get();
                foreach($alluser as $value){
                    $all_token[] = $value->device_token;
                 };
                return response()->json(['result' => $all_token,'status'=> "Professional"]);
             }
        }else if($role == "Organization"){
            if(empty($check)){
                return response()->json(['result' => '','status'=> "Organization"]);
             }else{
                $alluser = User::where('role',$role)->get();
                foreach($alluser as $value){
                    $all_token[] = $value->device_token;
                 };
                return response()->json(['result' => $all_token,'status'=> "Organization"]);
             }
        }else if($role == "Recruiter"){
            if(empty($check)){
                return response()->json(['result' => '','status'=> "Recruiter"]);
             }else{
                $alluser = User::where('role',$role)->get();
                foreach($alluser as $value){
                    $all_token[] = $value->device_token;
                 };
                return response()->json(['result' => $all_token,'status'=> "Recruiter"]);
             }
        }
      
    }
    public function activeStatus(Request $request){
        $status = $request->status;
        $id = $request->id;
        $data = User::find($id);

        if($data) {
            $data->status = $status;
            $data->save();
        }


      //  $data = User::where('id',$id)->update(['status'=>$status]);
    //  dd($data);
        return response()->json(['status'=> true]);

    }

    public function getSubscriptionTypeById($id){          
        $planType =  Subscription::where('_id',$id)->pluck('type');
        if($planType){
            return $planType[0];
        }
        return "N/A";
    }
    //----- admin logout code -----//
    public function logout(Request $request) {

        sessionStorage.clear(); 
        // localStorage.Item('authToken', data.access_token);
        //                     localStorage.setItem('UID', data.data._id);
        
        // dd(Auth::user());
        // Session::flush();
        localStorage.clear();
        // Auth::logout();
        return redirect()->route('adminsignin');
     
      }
      public function readUnread(Request $request){
            $id = $request->id;
            $data  = Support_Message::where('support_id',$id)->where('is_type','User')->update(['read_unread'=>'true']);
            if($data){
                return response()->json(['status'=>true]);
            }else {
                return response()->json(['status'=>false]);
             }
      }
}
