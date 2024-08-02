<?php

namespace App\Http\Controllers\Frontend;


use App\Commons\APICode;
use App\Commons\Response;
use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\RewardPointTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    private $review;
    private $response;

    public function __construct(Review $review, Response $response)
    {
        $this->review = $review;
        $this->response = $response;
    }

    public function create(Request $request)
    {
        $validator = $this->review->validateCreate($request);
        if ($validator->code == APICode::SUCCESS) {
            $review = new Review();
            $review->user_id = Auth::id();
            $review->place_id = $request->place_id;
            $review->score = $request->score;
            $review->comment = $request->comment;
            $review->save();
            if(Auth::user()->user_type == User::USER_TYPE_USER){
                $getreview = Review::where('user_id',Auth::id())->where('place_id',$request->place_id)->get();
                if($getreview->count() > 0){
                    if($getreview->count() == 1){
                        //$getrewardpoint = RewardPointTransaction::where('user_id',Auth::id())->where('transaction_type',1)->orderBy('created_at','DESC')->first();
                        $data['user_id'] = Auth::id();
                        $data['transaction_type'] = 1;
                        $data['title'] = 'Place review point';
                        $data['description'] = 'You have earned 2 points.';
                        // if(!empty($getrewardpoint)){
                        //     $data['points'] = $getrewardpoint->points + 2;
                        //     $data['balance'] = $getrewardpoint->balance + 2;
                        //     $getrewardpoint->update($data);
                        // }else{
                            $data['points'] = 2;
                            $data['balance'] = 2;
                            if(isUserHaveMembership()){
                                RewardPointTransaction::create($data);
                            }
                        //}
                    }
                }else{
                    $data['user_id'] = Auth::id();
                    $data['transaction_type'] = 1;
                    $data['title'] = 'Place review point';
                    $data['description'] = 'You have earned 2 points.';
                    $data['points'] = 2;
                    $data['balance'] = 2;
                    RewardPointTransaction::create($data);
                }
            }
        }
        return $this->response->formatResponse($validator->code, [], $validator->message);
    }
}
