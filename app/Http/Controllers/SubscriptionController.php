<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Subscription; 
use App\Models\User_Subscription; 
use Exception;
use Stripe;
use App\Models\Payment; 
class SubscriptionController extends Controller
{
    public function createSubscription(Request $request){

      
       try {  
         
            $subscription = Subscription::create([ 
           'title' =>  isset($request->title) ? $request->title : '',
           'type' =>  isset($request->type) ? $request->type : '',
           'descriptions_points' =>  isset($request->descriptions_points) ?        $request->descriptions_points : '',
           'price' =>  isset($request->price) ? $request->price : '',
           'plan_type' =>  isset($request->plan_type) ? $request->plan_type : '',
            
           ]); 
           //return $subscription;
           if ($subscription) {
               return response()->json([
                   'success' => true,
                   'code' => 200,
                   'message' => 'Subscription successfully created',
                   'data' => $subscription
               ], 200);
           } else {
               return response()->json([
                   'success' => false,
                   'code' => 404,
                   'message' => 'There is an issue while create the subscription',
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
public function getsubscription(Request $request){

    try { 
        $user = $request->user();  
        $userId = $user->_id; 

        $subscription = Subscription::all();

        $subscriptionData = [];
        if($subscription){
            foreach($subscription as $subs){
                $isSubscribed = User_Subscription::where('subscription_id',$subs->_id)->where('user_id',$userId)->first();
                $subscriptionData[] = array(
                    "_id" => $subs->_id,
                    "title" => $subs->title,
                    "type" => $subs->type,
                    "descriptions_points" => $subs->descriptions_points,
                    "price" => $subs->price,
                    "plan_type" => $subs->plan_type,
                    'is_subscribed' => isset($isSubscribed) ? $isSubscribed : null,
                    "updated_at" => $subs->updated_at,
                    "created_at" => $subs->created_at,
                );

            }
        } 
            if (($subscriptionData)) { 
                return response()->json(['success' => true, 'code' => 200, 'data' => $subscriptionData, 'message' => 'Subscription Listing']);
            } else {
                return response()->json(['success' => false, 'data' => '', 'message' => 'Subscription not found', 'code' => 404]);
            }
        }
        catch(Exception $e) {
            return response()->json(['success' => false, 'code' => 404, 'message' => $e->getMessage()
        ], 404);
        }
}
 

    public function userCreateSubscription(Request $request)
    {
        $validator = Validator::make($request->all(), [  
            'subscription_id' => 'required', 
            'card_id'=>'required'
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
        $userId = $user->_id; 
        $subscriptionID = $request->subscription_id;
        $cardID = $request->card_id;
        $checkUserSubscription = User_Subscription::where('user_id', '=', $userId)->get(); 
         if(count($checkUserSubscription) >0)
         {
            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'User already subscribed',
                'data' => $checkUserSubscription
            ], 200);
         }
              else{
           

            $stripe = new \Stripe\StripeClient(
                'sk_test_51LJDoSJJ1krQve8fCtu9exTB544kup30GEJhijwTrWbIisMOAQfR5PKBNiJAbjfEnSTUHOAZUh3vCvhTqYb1H8OU00FF1z8ypu'
              );  
             
               $getCustomerid = Payment::where('card_id',$cardID)->first(); 
               $customer_id=  $getCustomerid->customer_id;

                $getpriceID = $stripe->prices->retrieve('price_1LieXMJJ1krQve8fTRQOlzAC', []);
                $priceID = $getpriceID->id;
                  
            
               $subscriptionCreate =  $stripe->subscriptions->create([
                'customer' => $customer_id,
                'items' => [
                  ['price' => $priceID],
                ],
                'metadata' => [
                    'start_date' => time(),
                ],
                'payment_behavior' => 'allow_incomplete',
                'expand' => ['latest_invoice.payment_intent'] 
              ]); 
                
              $subscriptionData = User_Subscription::updateOrCreate([
                'user_id' => $userId,
            ],[ 
                'user_id'=>$userId,
                'subscription_id' => $subscriptionID,
                'stipeSubscriptionID'=>$subscriptionCreate->id,
                'card_id' => $cardID,
                'is_subscribed'=>true
            ]); 

                if ($subscriptionData) {
                return response()->json([
                    'success' => true,
                    'code' => 200,
                    'message' => 'User subscription created',
                    'data' => $subscriptionData
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'code' => 404,
                    'message' => 'There is an issue while creating subscription',
                ], 404);
            }
        } } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => $e->getMessage(),
            ], 404);
        }
    }


    public function userCancelSubscription(Request $request)
    {
        $validator = Validator::make($request->all(), [  
            'subscription_id' => 'required', 
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
           $subscriptionID = $request->subscription_id; 
        try {   
           
            $stripe = new \Stripe\StripeClient(
                'sk_test_51LJDoSJJ1krQve8fCtu9exTB544kup30GEJhijwTrWbIisMOAQfR5PKBNiJAbjfEnSTUHOAZUh3vCvhTqYb1H8OU00FF1z8ypu'
              );  
            
           $cancelSubscription=   $stripe->subscriptions->cancel(
                        $subscriptionID,
                []
              ); 
                if ($cancelSubscription) { 
                    $deleteCardDB = User_Subscription::where('stipeSubscriptionID',$subscriptionID)->where('user_id',$userId)->delete();
                return response()->json([
                    'success' => true,
                    'code' => 200,
                    'message' => 'Plan subscription has been cancelled',
                    'data' => $cancelSubscription
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'code' => 404,
                    'message' => 'There is an issue occur while cancel subscription',
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

}