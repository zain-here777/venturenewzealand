<?php

namespace App\Http\Controllers\Admin;


use Carbon\Carbon;
use App\Models\Competition;
use Illuminate\Http\Request;
use App\Models\WebNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\RewardPointTransaction;
use App\Models\CompetitionParticipation;
use Astrotomic\Translatable\Validation\RuleFactory;




class CompetitionController extends Controller
{



    public function list(Request $request)
    {
        $competitions = Competition::all();

        return view('admin.competitions.competition_list', [
            'competitions' => $competitions
        ]);

    }


    public function createView(Request $request)
    {
        $competition = Competition::where('id', $request->id)->first();
        return view('admin.competitions.competition_create', compact('competition'));
    }

    public function create(Request $request)
    {
        $rule_factory = RuleFactory::make([
            'title' => '',
            'description' => '',
            'terms_and_conditions' => '',
            'image' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'entry_fee_points' => '',
            'prize_points' => '',
            'start_end_date' => '',
            // 'start_date' => '',
            // 'end_date' => '',
        ]);
        $data = $this->validate($request, $rule_factory);

        if ($request->hasFile('image')) {
            $thumb = $request->file('image');
            $thumb_file = $this->uploadImage($thumb, '');
            $data['image'] = $thumb_file;
        }

        if ($request->hasFile('background_image')) {
            $thumb = $request->file('background_image');
            $thumb_file = $this->uploadImage($thumb, '');
            $data['background_image'] = $thumb_file;
        }

        $model = new Competition();

            $start_end_date = $request->start_end_date;
            $date_arr = explode("-",$start_end_date);
            $start_date  = Carbon::createFromFormat('d/m/Y', trim($date_arr[0]," "))->format('Y-m-d');
            $end_date  = Carbon::createFromFormat('d/m/Y', trim($date_arr[1]," "))->format('Y-m-d');
            $model->start_date = $start_date;
            $model->end_date = $end_date;

        $model->fill($data);

        if ($model->save()) {
            return redirect(route('admin_competition_list'))->with('success', 'Create competition success!');
        }

    }

    public function update(Request $request) {
        $rule_factory = RuleFactory::make([
            'title' => '',
            'description' => '',
            'terms_and_conditions' => '',
            'image' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'entry_fee_points' => '',
            'prize_points' => '',
            'start_date' => '',
            'end_date' => '',
        ]);
        $data = $this->validate($request, $rule_factory);

        if ($request->hasFile('image')) {
            $thumb = $request->file('image');
            $thumb_file = $this->uploadImage($thumb, '');
            $data['image'] = $thumb_file;
        }

        if ($request->hasFile('background_image')) {
            $thumb = $request->file('background_image');
            $thumb_file = $this->uploadImage($thumb, '');
            $data['background_image'] = $thumb_file;
        }

        $model = Competition::find($request->competition_id);

            $start_end_date = $request->start_end_date;
            $date_arr = explode("-",$start_end_date);
            $start_date  = Carbon::createFromFormat('d/m/Y', trim($date_arr[0]," "))->format('Y-m-d');
            $end_date  = Carbon::createFromFormat('d/m/Y', trim($date_arr[1]," "))->format('Y-m-d');
            $model->start_date = $start_date;
            $model->end_date = $end_date;

        $model->fill($data);

        if ($model->save()) {
            return redirect(route('admin_competition_list'))->with('success', 'Update competition success!');
        }
    }

    public function destroy($id) {
        Competition::destroy($id);
        return back()->with('success', 'Delete competition success!');
    }

    public function participants_list(Request $request, $competition_id)
    {
        $competition = Competition::query()->where('id',$competition_id)->first();

        if($competition==null){
            return redirect()->back()->with('error','Competition does not exists!');
        }

        $competitions_participants = CompetitionParticipation::query()
                            ->with('user')
                            ->where('competition_id', $competition_id)
                            ->get();

        $competition_winner = CompetitionParticipation::query()
                            ->with('user')
                            ->where('competition_id', $competition_id)
                            ->where('status', CompetitionParticipation::STATUS_WIN)
                            ->first();

        return view('admin.competitions.participants_list', [ 'competition' => $competition,
            'competitions_participants' => $competitions_participants,
            'competition_winner' => $competition_winner
        ]);
    }

    public function participantDeclareWinner($id) {

        $participant = CompetitionParticipation::where('id',$id)->first();

        $competition_winner = CompetitionParticipation::query()
                            ->with('user')
                            ->where('competition_id', $participant->competition_id)
                            ->where('status', CompetitionParticipation::STATUS_WIN)
                            ->first();

        if($competition_winner!=null){
            return back()->with('error', 'Winner already declared!');
        }

        if($participant){
            $user_id = $participant->user_id;
            $prize_points = $participant->prize_points;

            $competition = Competition::query()->where('id',$participant->competition_id)->first();

            if($prize_points!=null){
                RewardPointTransaction::addTransaction(RewardPointTransaction::TRANSACTION_ADD,[
                    'user_id' => $user_id,
                    'competition_id' => $participant->competition_id,
                    'points' => $prize_points,
                    'title' => $participant->competition->title,
                ]);
            }
            else
            {
                $title = $competition->title;
                $body = "You have won the ".$competition->title." competition";

                if($competition->image){
                    $image = asset("uploads/".$competition->image);
                }
                else{
                    $image = NULL;
                }

                WebNotification::create(
                    [
                        'title' => $title,
                        'body' => $body,
                        'image' => $image,
                        'type' => WebNotification::TYPE_SINGLE, //Single = 2
                        'for_user_id' => $participant->user_id,
                    ]
                );
            }

        }

        $participant->update(['status'=>CompetitionParticipation::STATUS_WIN]);
        return back()->with('success', 'Winner declare success!');
    }

}
