<?php

namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use App\Models\Story;
use App\Models\User;
use App\Models\interestedStory;
use App\Models\Follow;
use App\Models\MultipleImageUpload;
use Laravel\Sanctum\PersonalAccessToken;
use DB;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class StoryController extends Controller
{ 
    public function image_upload(Request $request)
    {   
        
        $validator = Validator::make($request->all(), [            
            'image' => 'required|mimes:jpeg,png,jpg,gif,pdf,svg,mp4,webm,3gp,mov,flv,avi,wmv|max:100000'
        ]);
        
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'code' => 404, 
                'message' => $validator->errors(),
            ], 404);
        } 

        try{
            if($request->hasFile('image')){
                $fileName= $request->file('image')->getClientOriginalName();
                $getImage = $request->image;
                $imageName = time().'.'.$getImage->extension();
                $imagePath = public_path(). '/images/'.$request->type;
                $imageUrl = '/images'.$request->type.'/'.time().'.'.$getImage->extension(); 
                $getImage->move($imagePath, $imageName);
            }
            return response()->json(['success'=>true,'code' => 200,'data'=>$imageUrl,
            'fileName'=>$fileName,'message' => 'File has been uploaded successfully']); 
        }
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'code' => 404, 
                'message' => $e->getMessage(),
            ], 404);
        }

    
        

}
     
// public function rules()
// {
//     $rules = [
//         'title' => 'required',
//     ];
//     foreach($this->request->get('slide') as $key => $val){
//         $rules['slide.'.$key.'.title'] = 'required|max:255';
//         $rules['slide.'.$key.'.description'] = 'required|max:255';
//     }
//     return $rules;
// }

   public function store(Request $request)
   {
 
    try{
        $validator = Validator::make($request->all(), [
            'title.*' => 'required|string',
            'bgcolor.*' => 'required|string',
            'description.*' => 'required|string',
            'keywords.*' => 'required|string',
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'code' => 404, 
                'message' => $validator->errors(),
            ], 404);
        }
    }
    catch(Exception $e){
        return response()->json([
            'success' => false,
            'code' => 404, 
            'message' => $e->getMessage(),
        ], 404);
    }

    try
       { 
         $user_id = $request->user()->id;
        $user = $request->user();
        $userName = $user->name;        
        $storydata = $request->all(); 
        //return $storydata;
        foreach($storydata as $key => $value){

            $story = new Story; 
            $story->image = $value['image'];
            $story->bgcolor = $value['bgcolor'];
            $story->title = $value['title']; 
            $story->description = $value['description'];
            $story->keywords = $value['keywords']; 
            $story->user_id = $user_id; 
            $story->save(); 
           
        }
 
        $userFollowID = Follow::where('follower_id',$user_id)->pluck('user_id')->toArray();
        if($userFollowID)
        {
          foreach($userFollowID as $foid){
                $userDeviceToken = User::where('_id',$foid)->value('device_token');

                if($userDeviceToken)
                {
                    $user_id = $foid;
                    $device_token= $userDeviceToken; 
                    $type="storyCreatedbyFollowed";
                    $title="Story created by followed person";
                    $Desription=  " Story created by " .$userName;
                    $sendNotification = sendPushNotification($request,$user_id,$type,$title,$Desription, $device_token);
                } 
          }   
        }

        // $userFollowID = Follow::where('follower_id',$user_id)->pluck('user_id')->toArray();  
        // if($userFollowID)
        // {
        //     foreach($userFollowID as $data)
        //     {
        //  $getUserData = User::where('_id',$data)->first(); 
        //     // $userId= $getUserData->_id; 
        //    // $userName= $getUserData->name; 
        //     $device_token= $getUserData->device_token; 
        //     $type="storyCreatedbyFollowed";
        //     $title="Story created by followed person";
        //     $Desription= "Story created by " .$userName;
        //     $sendNotification = sendPushNotification($request,$user_id,$type,$title,$Desription,$device_token);
        //  } }

        return response()->json(['success'=>true,'code' => 200,'data'=>$story,'message' => 'story added Successfully']); 
    }
    catch (Exception $e) {
        return response()->json([
            'success' =>  false,
            'code' => 404,  
            'message' => $e->getMessage(),
        ],404);
    }

}

public function stories(Request $request)
{     
    try
    { 
        $user = $request->user();
        $user_id = $user->id;  
        $getFollowersIds = $user->follower->pluck('follower_id')->toArray();  

        // Get user stories
        //$stories = $user->stories;
       $stories = User::has('stories')->with('stories')->where('_id',$user_id)->get();      
        // Get followed users stories
          $storydata = User::has('stories')->with('stories')->whereIn('_id',$getFollowersIds) 
         ->orderBy('updated_at', '>', 'created_at','Asc')
         ->get();        
    
        $mergedStoryData = $stories->merge($storydata);
    
        if(count($mergedStoryData)) { 
            return response()->json(['success'=>true,'code' => 200,'story_count' => count($mergedStoryData),'data'=>$mergedStoryData,'message' => 'List of Stories']); 

        } else {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => 'No story found',
            ], 404);
        }
    }
catch (Exception $e) {
    return response()->json([
        'success' =>  false,
        'code' => 404, 
        'message' => $e->getMessage(),
    ],404);
}

}

public function story(Request $request,$id)
   {    
        // return $request->user();
        //$role = Story::find($id); 
        $currentTIme=  Carbon::now()->format('Y-m-d H:i:s');
            $storyId = Story::where('user_id','=', $id)->get(); 
           //  return $role;
            try
            { 
            if(count($storyId) >=1)
            {
            $updateStory=User::where('user_id',$id)->update(['updated_at'=>date($currentTIme)]);
            return response()->json(['success'=>true,'code' => 200,'data'=>$storyId,'message' => 'Listing of Stories']); 

            }
            else
            {
            return response()->json(['success'=>false,'data'=>'','message' => 'Data not found','code' => 404]);
            }  

            }

            catch (Exception $e) {
            return response()->json([
                'success' =>  false,
                'code' => 404, 
                'message' => $e->getMessage(),
            ],404);
            }

}

public function interestedStory(Request $request){
    try
    { 
            $user = $request->user();
            $userName= $user->name; 
            $storyID = $user->stories->pluck('_id')->first(); 
            $storyUserID = $user->stories->pluck('user_id')->first(); 
            $interestedUserID= $request->user_id;  
        
         $interestedStory = interestedStory::create([
            'user_id' => $interestedUserID,
            'story_id' => $storyID,
            'story_user_id' => $storyUserID, 
        ]);

         if ($interestedStory) {   
              $getUserData = User::where('_id',$interestedUserID)->first();  
             if($getUserData)
            {
               // $userName= $getUserData->name;
               
                $userId= $getUserData->_id; 
                $device_token= $getUserData->device_token; 
                $type="interestedStory";
                $title="User has interested in story";
                $Desription=$userName ." is interested in your story";
                $sendNotification = sendPushNotification($request,$userId,$type,$title,$Desription, $device_token);
            }

            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'User has interested in story',
                'data' => $interestedStory
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => 'There is an issue while interest in the story',
            ], 404);
        }
    }

    catch (Exception $e) {
    return response()->json([
        'success' =>  false,
        'code' => 404, 
        'message' => $e->getMessage(),
    ],404);
    }
}

}