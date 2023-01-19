<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;
use Exception;
use DB;
use App\Models\Comment;
use App\Models\Like;
use App\Models\unLike;
use App\Models\Hide_Post;
use App\Models\User;
use App\Models\Follow;
use App\Models\Push_card;
use Carbon\Carbon;

class PostController extends Controller
{
    //Create a Post
    public function createPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => $validator->errors(),
            ], 404);
        } 
        $user = $request->user();
            $userId = $user->_id;  
        $userName= $user->name;
        try {
            //save data into the db
             $post = Post::create([
                'user_id' => $userId,
                'description' => $request->description,
                'status' => 'publish',
                'media' => isset($request->image) ? $request->image : '',
            ]);  
            if ($post) {   
                   $userFollowID = Follow::where('user_id',$userId)->pluck('follower_id')->toArray();  
            if($userFollowID)
            {
                foreach($userFollowID as $data)
                {
             $getUserData = User::where('_id',$data)->first(); 
                $userId =  $getUserData->_id;
              
             // $userName= $getUserData->name; 
                $device_token= $getUserData->device_token; 
                $type="postCreatedbyFollowed";
                $title="Post created by followed person";
                $Desription= "Post created by " .$userName;
                $sendNotification = sendPushNotification($request,$userId,$type,$title,$Desription,$device_token);
             } }
                return response()->json([
                    'success' => true,
                    'code' => 200,
                    'message' => 'Post created successfully',
                    'data' => $post
                ], 200); 
            } else {
                return response()->json([
                    'success' => false,
                    'code' => 404,
                    'message' => 'There is an issue while creating the post',
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => $e->getMessage(),
            ], 404);
        }
    }

    public function array_flatten($array) { 
        if (!is_array($array)) { 
          return FALSE; 
        } 
        $result = array(); 
        foreach ($array as $key => $value) { 
          if (is_array($value)) { 
            $result = array_merge($result, $this->array_flatten($value)); 
          } 
          else { 
            $result[$key] = $value; 
          } 
        } 
        return $result; 
    } 

    //Get all posts
    public function getAllPosts(Request $request)
    {
        try {
            $finaIds = [];
            $user = $request->user();            
            $userId = $user->_id;
            //$userpost = $user->posts;
             
            $userpost =  Post::where('user_id', $userId) 
            ->with('user','comment')->get();

            $hiddenPostIds = Hide_Post::where("user_id",$userId)
                ->where("single_post",1)
                ->pluck('post_id')
                ->toArray();

            $hiddenUserPostIds = Hide_Post::where("user_id",$userId)
            ->where("all_post",1)
            ->pluck('all_post_ids')
            ->toArray(); 

            $hiddenUserPostIds = $this->array_flatten($hiddenUserPostIds);

            $getFollowersIds = $user->follower->pluck('follower_id')->toArray();
             
            $finaIds = array_merge( $hiddenUserPostIds,$hiddenPostIds); 
            
               $posts = Post::whereNotIn('_id', $finaIds)
            ->whereIn('user_id',$getFollowersIds)
            ->with('user','comment')->orderBy('created_at','Desc')->get();
        

            // $getPushCards = Push_card::whereDate('date', '=', Carbon::now()->format('Y-m-d'))->get(); 
            // $adminPushCards= $posts->merge($getPushCards);

            // $postData = $userpost->merge($adminPushCards)->sortByDesc('updated_at')->values();


            $postData = $userpost->merge($posts)->sortByDesc('updated_at')->values();

            if  (count($postData)) {
                return response()->json([
                    
                    'success' => true,
                    'code' => 200,
                    'post_count' => count($postData),
                    'message' => 'Post fetched successfully',
                    'data' => $postData,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'code' => 404,
                    'message' => 'No post found',
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' =>  $e->getMessage(),
            ], 404);
        }
    }

    public function comments(Request $request)
    { 
        $validator = Validator::make($request->all(), [
            //  'image' => 'required|mimes:jpeg,png,jpg,gif',
            'comment' => 'required|string',
            'post_id' => 'required' 
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 404, 
                'message' => $validator->errors(),
            ], 404);
        }
        try {

            $post = Post::where('_id',$request->post_id)->first();
            if(empty($post))
            {
                return response()->json([
                    'success' => false,
                    'code' => 404, 
                    'message' => 'Post ID is not valid',
                ], 404);
            } 
            $user = $request->user();
            
            $username=  $user->name;
            $userimage= $user->image;

           
            // $followerID= $request->follower_id;
            // $userRole = $user->role;
            // $userId = $user->_id; 
            // $type="Comment";
            // $title="user comment post";
            // $Desription="Comment post by ".$username;

            
            $userId = $user->_id; 
            //$device_token = $user->device_token;
            if ($post) {
                $postId = $post->id;
                $comment = new Comment;
                $comment->comment  = $request->comment;
                $comment->name  = $username;
                $comment->image  = $userimage;
                $comment->user_id= $userId;
                $comment->post_id = $postId;
                $save = $comment->save(); 
                if ($save) { 
                    
             $userFollowID = Post::where('_id',$postId)->pluck('user_id')->first();  
            if($userFollowID){
            $getUserData = User::where('_id',$userFollowID)->first();  
          //  $username=  $getUserData->name;
            $userId = $getUserData->_id;
            $type="Comment";
            $title="user comment post";
            $Desription="Comment post by ".$username;
            $device_token = $getUserData->device_token;
          
            $sendNotification = sendPushNotification($request,$userId,$type,$title,$Desription,$device_token);
            } 
                    return response()->json([
                        'success' => true,
                        'code' => 200,
                        'message' => 'Comment created successfully',
                        'data' => $comment
                    ], 200);
                    
                } else {
                    return response()->json([
                        'success' => false,
                        'code' => 404,
                        'message' => 'There is an issue while creating the comment',
                    ], 404);
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'code' => 404,
                'success' =>  false,
                'message' => 'Something went wrong'
            ], 404);
        }
    }

    public function like_post(Request $request)
    { 
        $validator = Validator::make($request->all(), [
            'post_id' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => $validator->errors(),
            ], 404);
        }
        $post = Post::where('_id',$request->post_id)->first();
            if(empty($post))
            {
                return response()->json([
                    'success' => false,
                    'code' => 404, 
                    'message' => 'Post ID is not valid',
                ], 404);
            } 
 
        try {
 
            $user = $request->user();
            $userId = $user->_id;
            $userName = $user->name;
            // $device_token = $user->device_token;
            

               $postexist = Like::where('post_id',$request->post_id)->where('user_id',$userId)->first(); 

            if($postexist){
                $postIddelete=Like::find($postexist)->each->delete();   
                if($postIddelete)
                {
                    $unlike = new unLike;
                    $unlike->post_id = $request->post_id;
                    $unlike->user_id = $userId;
                    $save = $unlike->save();
                return response()->json([
                    'success' => true,
                    'code' => 200, 
                    'message' => 'Post unlike',
                    'data'=>$unlike,
                ], 200);
            }
            }
            else
            { 
                $postexist = unLike::where('post_id',$request->post_id)->where('user_id',$userId)->first();
                if($postexist){
                $postIddelete=unLike::find($postexist)->each->delete(); 
               
                }
                $like = new Like;
                $like->post_id = $request->post_id;
                $like->user_id = $userId;
                $save = $like->save();
         if ($save) {  
            
            
            //    print_r('id',$request->post_id);
            $userFollowID = Post::where('_id',$request->post_id)->pluck('user_id')->first();  
            if($userFollowID){
            $getUserData = User::where('_id',$userFollowID)->first();  
          
          //  $username=  $getUserData->name;
                $userId = $getUserData->_id;
                $type="Like";
                $title="User like post";
                $Desription="Like post by ".$userName;
                $device_token = $getUserData->device_token;
            $sendNotification = sendPushNotification($request,$userId,$type,$title,$Desription,$device_token); 
           
            }
            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'Post liked',
                'data'=>$like, 
            ], 200);
            
        } else {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => 'There is an issue while adding a like',
            ], 404);
        }
    }
        } catch (Exception $e) {
            return response()->json([
                'success' =>  false,
                'code' => 404, 
                'message' => 'Error: ' . $e->getMessage()
            ], 404);
        }
    }

    

    public function unlike_post(Request $request)
    { 
        $validator = Validator::make($request->all(), [
            'post_id' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => $validator->errors(),
            ], 404);
        }
        $post = Post::where('_id',$request->post_id)->first();
       // return $post->id;

            if(empty($post))
            {
                return response()->json([
                    'success' => false,
                    'code' => 404, 
                    'message' => 'Post ID is not valid',
                ], 404);
            } 

            $postid = Like::where('post_id',$post->id)->first();
            if($postid)
            {
                $res=Like::find($postid)->each->delete();     
              // return $res;
            }
        try {
 
            $user = $request->user();
            $userId = $user->_id;

         $unlike = new unLike;
         $unlike->post_id = $request->post_id;
         $unlike->user_id = $userId;
         $save = $unlike->save();

        // return $save;
         if ($save) { 
            
            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'Post unliked',
                'data'=>$unlike,

            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => 'There is an issue while adding a unlike',
            ], 404);
        }

        } catch (Exception $e) {
            return response()->json([
                'success' =>  false,
                'code' => 404, 
                'message' => 'Something went wrong'
            ], 404);
        }
    }

    public function hide_post(Request $request)
    {
        $allPostByUser = [];
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'post_id' => 'required',
            'post_user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => $validator->errors(),
            ], 404);
        }
        $post = Post::where('_id',$request->post_id)->first();
        if(empty($post))
        {
            return response()->json([
                'success' => false,
                'code' => 404, 
                'message' => 'Post ID is not valid',
            ], 404);
        } 
        $request->type == 'single' ? $single = 1 : $single = 0;
        $request->type == 'all' ? $all = 1 : $all =  0;

        $hidepost = Hide_Post::where('post_id', $request->post_id)->first();
        // die($hidepost);
       
        if($request->type == "all"){
            $allPostByUser = Post::where("user_id",$request->post_user_id)
            ->pluck('_id')
            ->toArray();
        }
        
        if($hidepost && $request->post_id == $hidepost->post_id)
        {

            if($hidepost->single_post == $single){
                return response()->json([
                    'success' => false,
                    'code' => 404,
                    'message' => 'Post already hidden',
                ], 200);
            }
            if($hidepost->all_post == $all){
                return response()->json([
                    'success' => false,
                    'code' => 404,
                    'message' => 'All posts from this user alreay hidden',
                ], 404);
            }
        }

        try {

        $user = $request->user();
        $userId = $user->_id;

         $hidepost = new Hide_Post;
         $hidepost->post_id = $request->post_id;
         $hidepost->post_user_id = $request->post_user_id;
         $hidepost->user_id = $userId;
         $hidepost->single_post = $single;
         $hidepost->all_post = $all;
         $hidepost->all_post_ids = $allPostByUser;
         $hidepost = $hidepost->save();

         if ($hidepost) {
            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'Post hidden successfully',
                'data'=>[],

            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'code' => 404,
                'data'=>'',
                'message' => 'There is an issue while hiding the post',
            ], 404);
        }

        } catch (Exception $e) {
            return response()->json([
                'success' =>  false,
                'code' => 404, 
                'message' => 'Something went wrong'
            ], 404);
        }
    }

    public function share(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => $validator->errors(),
            ], 404);
        }
    try{
            $post = Post::find($request->post_id);            
            if ($post) {
                
                $post->share += 1;
                $post->save();

                if (intval($post->id)) {
                    return response()->json([
                        'success' => true,
                        'code' => 200,
                        'message' => 'Post Share successfully',
                        'data' => $post
                    ], 200);
                }  
            }
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => 'Post not found',
            ], 404);
                
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => $e,
            ], 404);
        }

    }
}
