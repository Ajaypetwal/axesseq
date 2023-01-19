<?php

namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use Stripe;
use App\Models\Payment; 
use App\Models\User; 
use Illuminate\Support\Facades\Validator;
use Exception;
use DB;


class PaymentController extends Controller
{
    public function createCustomerOnStripe(Request $request)
    { 
      $validator = Validator::make($request->all(), [  
        'card_number' => 'required', 
        'exp_month' => 'required', 
        'exp_year' => 'required',  
        'cvc' => 'required',  
    ]); 
    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'code' => 404,
            'message' => $validator->errors(),
        ], 404);
    }   
        try{ 
          $getAllCard =[];
          $user = $request->user(); 
          
          $userId = $user->_id; 
          $userName = $user->name; 
          $userEmail = $user->email; 

          $stripe = new \Stripe\StripeClient(
            'sk_test_51LJDoSJJ1krQve8fCtu9exTB544kup30GEJhijwTrWbIisMOAQfR5PKBNiJAbjfEnSTUHOAZUh3vCvhTqYb1H8OU00FF1z8ypu'
          ); 
         
          $getAllCard= Payment::where('user_id',$userId)->get();
          if(count($getAllCard)>0)
          {
           $is_Default=false;
          }
          else
          {
            $is_Default=true;
          }

             $stripeToken= $stripe->tokens->create([
            'card' => [
              'name'=> isset($request->name) ? $request->name : '',
              'number' =>  isset($request->card_number) ? $request->card_number : '',
              'exp_month' =>  isset($request->exp_month) ? $request->exp_month : '',
              'exp_year' => isset($request->exp_year) ? $request->exp_year : '',
              'cvc' =>  isset($request->cvc) ? $request->cvc : '' 
            ],
          ]); 
          $cardLastFourNumber= $stripeToken->card->last4;
          $cardBrand= $stripeToken->card->brand;
          $cardName= $stripeToken->card->name;
           $customer = $stripe->customers->create([
            'source' => $stripeToken->id,
            'email' => $userEmail,
            'name' => $userName,
        ]); 
          $cardID= $customer->default_source;
          $customer_id= $customer->id;
          $card_token= $stripeToken->id; 

          $payment = Payment::create([
            'user_id' => $userId,
            'name' => $userName,
            'email' => $userEmail,
            'token' => $card_token,
            'customer_id' => $customer_id,
            'card_id'=> $cardID,
            'status'=>true,
            'cardLastFourDigit'=>$cardLastFourNumber,
            'cardBrand'=>$cardBrand,
            'cardName'=>$cardName,
            'is_Default'=> $is_Default
             
            ]); 
            if ($payment) {
                return response()->json([
                    'success' => true,
                    'code' => 200,
                    'message' => 'Card created',
                    'data' => $payment
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'code' => 404,
                    'message' => 'There is an issue while create the card',
                ], 404);
            } 
        }
        catch(\Stripe\Exception\CardException $e) { 
          return response()->json([
            'success' => true,
            'code' => 200,
            'message' => $e->getError()->message,
            'data' => ''
        ], 200); 
        }
    }

    public function getalllist(Request $request)
    {
      try{ 
        $user = $request->user(); 
        $userId = $user->_id; 
         $customer_id = [];
        $stripe = new \Stripe\StripeClient(
          'sk_test_51LJDoSJJ1krQve8fCtu9exTB544kup30GEJhijwTrWbIisMOAQfR5PKBNiJAbjfEnSTUHOAZUh3vCvhTqYb1H8OU00FF1z8ypu'
        );   
        //return $getCustomerIds = Payment::with('user')->where('user_id',$userId)->latest()->pluck('customer_id')->toArray();
         
        $getCustomerData = $user->userCards;
          // $getCustomerIds = $user->userCards->pluck('customer_id')->toArray(); 
          
          // $getCardDetail = [];
          // if(count($getCustomerIds) > 0){
          //   foreach($getCustomerIds as $k => $customer_id){
            
          //     $detail = $stripe->customers->allSources(
          //       $customer_id,
          //       ['object' => 'card', 'limit' => 10]
          //     ); 
            
          //     $getCardDetail[$k]   = $detail->data[0];
          //   }                  
          // }   
          if ($getCustomerData) { 
            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'Card detail',
                'data' => $getCustomerData
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'code' => 200,
                'message' => 'There is an issue while fetch the card',
                'data'=>[]
            ], 404);
        } 

      }
      catch(Exception $e) {
        return response()->json(['success' => false, 'code' => 404, 'message' => $e->getMessage() ], 404);
    }
    }

    public function deleteCardDetail(Request $request)
    {
     
        try{ 
          $user = $request->user(); 
          $userId = $user->_id;   
           
          $stripe = new \Stripe\StripeClient(
            'sk_test_51LJDoSJJ1krQve8fCtu9exTB544kup30GEJhijwTrWbIisMOAQfR5PKBNiJAbjfEnSTUHOAZUh3vCvhTqYb1H8OU00FF1z8ypu'); 
          $card_id = $request->card_id;
          $customer_id = $request->customer_id; 
          $paymentDetail = Payment::where('user_id',$userId)->get(); 

           $cardDelete= $stripe->customers->deleteSource(
            $customer_id,
            $card_id,
            []
          );  
          if ($cardDelete) {
          
            $deleteCardDB = Payment::where('card_id',$card_id)->where('customer_id',$customer_id)->delete();
            $getLastCardDB = Payment::where('user_id',$userId)->where('is_Default',true)->first(); 
          if($getLastCardDB){
             $firstData =  DB::table('payments')->where('user_id',$userId)->where('card_id',$getLastCardDB->card_id)->update(['is_Default'=>true]);
              
          }else {
             $getLastCardDB = Payment::where('user_id',$userId)->first(); 
             if(isset($getLastCardDB))
             {
             $firstData =  DB::table('payments')->where('user_id',$userId)->where('card_id',$getLastCardDB->card_id)->update(['is_Default'=>true]);
           }
          }

          
          
              //  if($firstData){
              //   dd('ok');
              //       $defaultCard = Payment::where('user_id',$userId)->where('is_Default',true)->first();
              //       $removePrevious = Payment::where('user_id',$userId)->where('card_id',$defaultCard->card_id)->update(['is_Default'=>false]);
              //  } 
            
            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'Card has been deleted',
                'data' => $cardDelete
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => 'There is an issue while delete the card',
            ], 404);
        }  

        }
        catch(Exception $e) {
          return response()->json(['success' => false, 'code' => 404, 'message' => $e->getMessage() ], 404);
      }
    }


    public function getSingleCardDetail(Request $request)
    { 
        try{ 
          $user = $request->user(); 
          $userId = $user->_id;    
          $stripe = new \Stripe\StripeClient(
            'sk_test_51LJDoSJJ1krQve8fCtu9exTB544kup30GEJhijwTrWbIisMOAQfR5PKBNiJAbjfEnSTUHOAZUh3vCvhTqYb1H8OU00FF1z8ypu'); 
          $card_id = $request->card_id;
          $customer_id = $request->customer_id; 
          $paymentDetail = Payment::where('user_id',$userId)->get();  
           $getCardDetail= $stripe->customers->retrieveSource(
            $customer_id,
            $card_id,
            []
          );  
          if ($getCardDetail) {  
            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'Get card detail',
                'data' => $getCardDetail
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'code' => 404,
                'message' => 'There is an issue while delete the card',
            ], 404);
        }  

        }
        catch(Exception $e) {
          return response()->json(['success' => false, 'code' => 404, 'message' => $e->getMessage() ], 404);
      }
    }


    public function updateCardDetail(Request $request)
    {   
        try{ 
          $user = $request->user(); 
          $userId = $user->_id;   
          $stripe = new \Stripe\StripeClient(
            'sk_test_51LJDoSJJ1krQve8fCtu9exTB544kup30GEJhijwTrWbIisMOAQfR5PKBNiJAbjfEnSTUHOAZUh3vCvhTqYb1H8OU00FF1z8ypu'); 
       
           $cardID =  isset($request->card_id) ? $request->card_id : '';
           $name   =  isset($request->name) ? $request->name : '';
           $exp_year   =  isset($request->exp_year) ? $request->exp_year : '';
           $exp_month   =  isset($request->name) ? $request->exp_month : '';
            // $stripeUpdatedToken= $stripe->tokens->create([
            //   'card' => [
              
            //     'exp_month' =>  isset($request->exp_month) ? $request->exp_month : '',
            //     'exp_year' => isset($request->exp_year) ? $request->exp_year : ''
               
            //   ],
            // ]); 
            //  $updatedToken=  $stripeUpdatedToken->id;
             $getCustomerIds = Payment::Where('card_id',$cardID)->first(); 
              $card_id=$getCustomerIds->card_id;
              $customer_id=$getCustomerIds->customer_id; 
          
           //$updateCustomer =  $stripe->customers->updateSource($customer_id, ['source' => $updatedToken]);
           $updateCustomer = $stripe->customers->updateSource(
            $customer_id,
            $card_id,
            ['exp_month' =>$exp_month,'exp_year' =>$exp_year,'name' =>$name]
          ); 

         $updateName = Payment::where('user_id',$userId)->where('card_id',$card_id)->update(['cardName'=>$name]); 

              if ($updateCustomer) {
                  return response()->json([
                      'success' => true,
                      'code' => 200,
                      'message' => 'Card detail updated',
                      'data' => $updateCustomer
                  ], 200);
              } else {
                  return response()->json([
                      'success' => false,
                      'code' => 404,
                      'message' => 'There is an issue while update the card',
                  ], 404);
              }  
        }
        catch(Exception $e) {
          return response()->json(['success' => false, 'code' => 404, 'message' => $e->getMessage() ], 404);
      }
    }

    public function cardSetDefault(Request $request)
    { 
      $validator = Validator::make($request->all(), [  
        'card_id' => 'required',  
      
    ]); 
    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'code' => 404,
            'message' => $validator->errors(),
        ], 404);
    }   
        try{ 
          $user = $request->user();  
          $userId = $user->_id; 
          $card_id= $request->card_id; 

          $stripe = new \Stripe\StripeClient(
            'sk_test_51LJDoSJJ1krQve8fCtu9exTB544kup30GEJhijwTrWbIisMOAQfR5PKBNiJAbjfEnSTUHOAZUh3vCvhTqYb1H8OU00FF1z8ypu'
          );

            $defaultCard = Payment::where('user_id',$userId)->where('is_Default',true)->first();
            if($defaultCard)
            {
              $removePrevious = Payment::where('user_id',$userId)->where('card_id',$defaultCard->card_id)->update(['is_Default'=>false]);

              if($removePrevious){
                $isDefault = DB::table('payments')->where('card_id',$card_id)->update(['is_Default'=>true]); 
              }
            }
          
            if ($isDefault) {
                return response()->json([
                    'success' => true,
                    'code' => 200,
                    'message' => 'Default card has been set',
                    'data' =>$isDefault,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'code' => 404,
                    'message' => 'There is an issue while set card default',
                ], 404);
            } 
        }
        catch(Exception $e) {
          return response()->json(['success' => false, 'code' => 404, 'message' => $e->getMessage() ], 404);
      }
    }
}