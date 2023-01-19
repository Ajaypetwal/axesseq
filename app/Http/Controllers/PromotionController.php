<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Promotion;
use App\Models\Role;

class PromotionController extends Controller
{
    public function createpromotion(Request $request)
    {
    $validator = Validator::make($request->all(), [

        'promotion_title' => 'required',
        'image' => 'required',
        'description' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
        'amount' =>'required', 
       
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

       if( $user->role == 'Organization')
       {

        $promotion = Promotion::create([
            'role' => isset($user->role) ? $user->role : '',
            'promotion_title' => isset($request->promotion_title) ? $request->promotion_title : '',
            'image' => isset($request->image) ? $request->image : '',
            'description' => isset($request->description) ? $request->description : '',
            'start_date' => isset($request->start_date) ? $request->start_date : '',
            'end_date' => isset($request->end_date) ? $request->end_date : '',
            'amount' => isset($request->amount) ? $request->amount : '',
           
           
        ]);
     
        
        if ($promotion) {
            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'Promotion created successfully',
                'data' => $promotion
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => 'There is an issue while creating the promotion',
            ], 404);
        }
    }
    else{

        return response()->json([
            'success' => false,
            'code' => 404,
            'message' => 'Role not authorized to create promotion',
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
}
