<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class RewardPointTransaction extends Model
{

    const TRANSACTION_ADD = 1;
    const TRANSACTION_MINUS = 2;

    protected $table = 'reward_point_transactions';

    protected $fillable = [
        'user_id', 'place_id', 'points', 'transaction_type', 'balance',
        'competition_id', 'title', 'description'
    ];

    public static function getBalance($user_id=false){

        if($user_id==false){
            $user_id = Auth::user()->id;
        }

        $rewardadd = self::where('user_id',$user_id)->where('transaction_type',1)->sum('points');
        $rewardminus = self::where('user_id',$user_id)->where('transaction_type',2)->sum('points');
        $reward = $rewardadd - $rewardminus;
        if($reward)
            return $reward;
        else
            return 0;

    }

    public function place(){
        return $this->hasOne(Place::class,'id','place_id');
    }

    public static function addTransaction($trans_type,$transactionData){

        $user_id = $transactionData['user_id'];
        $previousBalance = self::getBalance($user_id);

        if($trans_type==self::TRANSACTION_ADD){
            $balance = $previousBalance + $transactionData['points'];
            $description = "You have earned ".cleanDecimalZeros($transactionData['points'])." points.";
        }
        else if($trans_type==self::TRANSACTION_MINUS){
            if($previousBalance<$transactionData['points']){
                return "You don't have enough point balance.";
            }
            $balance = $previousBalance - $transactionData['points'];
            $description = "You have spent ".cleanDecimalZeros($transactionData['points'])." points.";
        }
        else
        {
            return "Invalid Transaction Type";
        }

        $last = self::create([
            'user_id' => $transactionData['user_id'],
            'place_id' => isset($transactionData['place_id'])?$transactionData['place_id']:NULL,
            'competition_id' => isset($transactionData['competition_id'])?$transactionData['competition_id']:NULL,
            'points' => $transactionData['points'],
            'transaction_type' => $trans_type, // 1:Add 2:Minus
            'balance' => $balance,
            'title' => isset($transactionData['title'])?$transactionData['title']:NULL,
            'description' => isset($transactionData['description'])?$transactionData['description']:$description,
        ]);

        return $last;
    }//addTransaction()

}
