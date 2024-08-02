<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Place;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\RewardPointTransaction;
use Carbon\Carbon;

class RewardController extends Controller
{
    public function reward(Request $request,$reward_link){
        $response_code = "1";
        $points = 0;
        if(Auth::user()){
            if(!isOperatorUser()){
                if(isUserHaveMembership()){
                    
                    $user_id = Auth::user()->id;
                    $place = Place::query()
                        ->where('reward_link',$reward_link)
                        ->first();
                
                    if($place!=NULL){

                        $today = Carbon::now()->format("Y-m-d");
                        $rewardPointTransaction = RewardPointTransaction::query()
                        ->where('user_id',$user_id)
                        ->where('place_id',$place->id)
                        ->where('transaction_type',1)
                        ->whereDate('created_at',$today)->first();
            
                        if($rewardPointTransaction==NULL){                        
                            $points = setting('reward_points'); // Get reward point to credit, from admin settings
                                
                            RewardPointTransaction::addTransaction(RewardPointTransaction::TRANSACTION_ADD,[
                                'user_id' => $user_id,
                                'place_id' => $place->id,
                                'points' => $points,
                                'title' => $place->name,                                            
                            ]);

                            //Success
                            $response_code = "2";

                        }
                        else
                        {
                            //Reward already given
                            $response_code = "3";
                        }        
                    }
                    else{                
                        //Place Not Found
                        $response_code = "4";
                    }

                }
                else{
                    //User does not have active membership
                    $response_code = "6";
                }
                
                
            }
            else{
               //Operator User not allowed
               $response_code = "5";
            }            
        }//auth user if
        return view('frontend.page.reward',['response_code' => $response_code,'points'=>$points]);
    }//reward

    public function rewardHistory(Request $request){

        $user_id = Auth::user()->id;
        $reward_point_transactions = RewardPointTransaction::query()->where('user_id',$user_id)->orderBy('id','DESC')        
        ->paginate(10);

        if(request()->ajax()){

            $data = [];
            foreach ($reward_point_transactions as $transaction) {
                $data[] = view('frontend.common.reward_transaction_item',['transaction'=>$transaction])->render();
            }
            return response()->json(['status'=>true,'data'=>$reward_point_transactions,'html'=>$data]);
        }
        else{
            return view('frontend.page.reward_history',['reward_point_transactions'=>$reward_point_transactions]);
        }        

    }//rewardHistory()
}
