<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Support,User,Support_Message,UserInfo};
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Str;

class SupportController extends Controller
{
    public function createSupport(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'subject' => 'required',
            'message' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => $validator->errors(),
            ], 404);
        }
        $user = $request->user();
        $userRole = $user->role;
        $userId = $user->_id;
        $serialNumber = 1;
        $lastRecord = Support::latest()->first();

        if($lastRecord){
            $serialNumber = sprintf('%02s',$lastRecord->serialNumber + 1);
        }

        $ticketNumber = 'AXQ-'.date("Y").'-'.$serialNumber;

        try {
             $support = Support::create([
                'user_id' => $userId,
                'role' => $userRole,
                'ticket_number' => $ticketNumber,
                'subject' => isset($request->subject) ? $request->subject : '',
                'message' => isset($request->message) ? $request->message : '',
                'upload_pic_video' =>  isset($request->upload_pic_video) ? $request->upload_pic_video : '',
                'serialNumber' => $serialNumber,
                'status' => "Pending"
            ]);
            if ($support) {
                return response()->json([
                    'success' => true,
                    'code' => 200,
                    'message' => 'Support created successfully',
                    'data' => $support
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'code' => 404,
                    'message' => 'There is an issue while creating the support',
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => $e,
            ], 404);
        }
    }
    public function get_user_support(Request $request) {
        $user = $request->user();
        $userID = $user->_id;
        $supportData = [];

        try {
            $data = Support::with('user:name,image')->where('user_id',$userID)->orderBy('_id','DESC')->get();

            if($data){
                $i = 0;
                foreach($data as $sd){
                    $supportData[] = array(
                        "_id" => $sd->_id,
                        "user_id" => $sd->user_id,
                        "role" => $sd->role,
                        "ticket_number" => $sd->ticket_number,
                        "subject" => $sd->subject,
                        "message" => $sd->message,
                        "upload_pic_video" => $sd->upload_pic_video,
                        "status" => $sd->status,
                        "updated_at" => $sd->updated_at,
                        "created_at" => $sd->created_at,
                        "user" => $sd->user,
                        "user_image" => isset( $sd->user->userinfo->image ) ? $sd->user->userinfo->image : ''
                    );

                    unset( $supportData[$i]['user_image'] );
                    $i++;
                }

            }

            if (count($supportData) > 0) {
                return response()->json(['success' => true, 'code' => 200, 'message' => 'User support data', 'data' => $supportData], 200);
            }
            return response()->json(['success' => false, 'code' => 200, 'message' => 'No data found','data' => '' ], 200);
        }
        catch(Exception $e) {
            return response()->json(['success' => false, 'code' => 404, 'message' => $e], 404);
        }
    }

    public function get_user_support_record(Request $request) {
        try {
        $user = $request->user();
         $userID = $user->_id;
        $supportID= $request->supportID;
        $supportData1 = [];

        $data = Support::where('_id', '=', $supportID)->where('user_id','=', $userID)
        ->with('user:name,image','support_message')->get();

        if($data){
            $i = 0;
            foreach($data as $sd){
                $supportData1[] = array(
                    "_id" => $sd->_id,
                    "user_id" => $sd->user_id,
                    "role" => $sd->role,
                    "ticket_number" => $sd->ticket_number,
                    "subject" => $sd->subject,
                    "message" => $sd->message,
                    "upload_pic_video" => $sd->upload_pic_video,
                    "status" => $sd->status,
                    "updated_at" => $sd->updated_at,
                    "created_at" => $sd->created_at,
                    "user" => $sd->user,
                    "user_image" => isset( $sd->user->userinfo->image ) ? $sd->user->userinfo->image : ''
                );

                unset( $supportData1[$i]['user_image'] );
                $i++;
            }

        }


        //$supportdata = Support_Message::where('support_id', '=', $supportID)->where//('user_id','=', $userID)
        //>with('user:name,image')->get();

       // return $supportdata;
            if ((count($data))){
                return response()->json(['success' => true,'code' => 200, 'data' =>$data,  'message' => 'User Support Detail']);
            } else {
                return response()->json(['success' => false, 'data' => '', 'message' => 'No Ticket Found', 'code' => 404]);
            }
        }
        catch(Exception $e) {
            return response()->json(['success' => false, 'code' => 404, 'message' => $e], 404);
        }
    }
    public function send_support_message(Request $request) {
        $validator = Validator::make($request->all(), [
            'message' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => $validator->errors(),
            ], 404);
        }
        try {
            $user = $request->user();
             $userID = $user->_id;


             $supportMessage = Support_Message::create([
                'user_id' => $userID,
                'message' => isset($request->message) ?  $request->message : '',
                'upload_pic_video' => isset($request->upload_pic_video) ?  $request->upload_pic_video : [ ],
                'support_id' => isset($request->support_id) ?  $request->support_id : '',
                'is_type' => "User",
                'read_unread' =>false,
            ]);
            if ($supportMessage) {
                return response()->json([
                    'success' => true,
                    'code' => 200,
                    'message' => 'Support message created successfully',
                    'data' => $supportMessage
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'code' => 404,
                    'message' => 'There is an issue while creating the support message',
                ], 404);
            }
            }
            catch(Exception $e) {
                return response()->json(['success' => false, 'code' => 404, 'message' => $e], 404);
            }
    }
}
