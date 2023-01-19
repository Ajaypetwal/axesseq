<?php

namespace App\Http\Controllers; 

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Calender;
use App\Models\Event;

class CalenderController extends Controller
{ 
  
    public function calender(Request $request){ 

        $validator = Validator::make($request->all(), [ 
            
            'event_id' => 'required', 
        ]); 
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => $validator->errors(),
            ], 404);
        } 
        try { 

            $eventid = Event::where('_id',$request->event_id)->first();
            if(empty($eventid))
            {
                return response()->json([
                    'success' => false,
                    'code' => 404, 
                    'message' => 'Event ID is not valid',
                ], 404);
            } 

            $user = $request->user(); 
    
           if( $user->role == 'Professional'  || $user->role == 'Recruiter'  || $user->role == 'Organization'  )
           {
            $data = Calender::create([
                'role' => isset($user->role) ? $user->role : '',
                'user_id' =>$user->id,
                'event_id' => isset($request->event_id) ? $request->event_id : '', 
            ]); 
            if ($data) {
                return response()->json([
                    'success' => true,
                    'code' => 200,
                    'message' => 'Event add to calender successfully',
                    'data' => $data
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'code' => 404,
                    'message' => 'There is an issue while Event add to calender',
                ], 404);
            }
           } 
        
        else{ 
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => 'Role not authorized to add data',
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


    public function get_event_calender(Request $request){  
           
        try {
            
            $user = $request->user();                        
            if($user){
                $data = $user->calender;
                if(count($data)>0){
                    return response()->json([
                        'success' => true,
                        'code' => 200,
                        'message' => 'Calender Listing',
                        'data'=>$data,
        
                    ], 200);
                }
                return response()->json([
                    'success' => false,
                    'code' => 404,
                    'message' => 'No event added to calender',
                ], 404);
            }
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => 'No User found.',
            ], 404); 

        } catch (Exception $e) {
            return response()->json([
                'success' =>  false,
                'code' => 404, 
                'message' => 'Something went wrong'
            ], 404);
        }
        }
        
        public function destroy(Request $request, $id) 
       {  
        try {
        $user = $request->user();
        $userId = $user->_id;

          $eventdelete = Calender::where('user_id',$userId)->firstorfail()->delete();

          if ($eventdelete) { 
            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'Event has been deleted from  calendar',
                'data'=>'',

            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => 'No event exits',
            ], 404);
        } 
       }
     catch (Exception $e) {
        return response()->json([
            'success' =>  false,
            'code' => 404, 
            'message' => 'Something went wrong'
        ], 404);
    }
}
}