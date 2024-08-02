<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function uploadImage($file, $dir)
    {
        //$file = $request->file('image');
        $extension = $file->getClientOriginalExtension();

        $filename = uniqid() . '_' . time() . '.' . $extension;

        $file->move("uploads/{$dir}", $filename);

        return $filename;
    }

    public function uploadmapImage($file, $dir)
    {
        //$file = $request->file('image');
        $extension = $file->getClientOriginalExtension();

        $filename = uniqid() . '_' . time() . '.' . $extension;

        $file->move("assets/images/countries/{$dir}", $filename);

        return $filename;
    }

    public function uploadCitymapImage($file, $dir)
    {
        //$file = $request->file('image');
        $extension = $file->getClientOriginalExtension();

        $filename = uniqid() . '_' . time() . '.' . $extension;

        $file->move("uploads/city/map/{$dir}", $filename);

        return $filename;
    }

    public function deleteImage($path)
    {
        return File::delete($path);
    }

    public function getUserByApiToken($request)
    {
        $api_token = $request->bearerToken();
        $user = User::where('api_token', $api_token)->first();

        return $user;
    }
    function escape_like($string)
    {
        $search = array('%', '_');
        $replace   = array('\%', '\_');
        return str_replace($search, $replace, $string);
    }

    public function checkTimeSlotOverlapping($timeslotval)
    {
        $timeslotval = array_combine(range(0, count($timeslotval)-1), array_values($timeslotval)); // handle index issue
        $numElements = count($timeslotval);
        for ($i=0; $i<$numElements ; $i++) {
            $startTimeObj =Carbon::parse($timeslotval[$i]['start_time']);
            $endTimeObj = $endtime = Carbon::parse($timeslotval[$i]['end_time']);

            $response =  ['status'=>false,'message'=>"Timeslots overlapped. Please select valid time slots"];
            $starttime = $startTimeObj->format('H:i:s');
            $endtime =  $endTimeObj->format('H:i:s');
            if($startTimeObj->timestamp > $endTimeObj->timestamp){
                return ['status'=>false,'message'=>"End Time must be greater than Start time"];
            }
            if ($i > 0) {
                for ($j=0; $j<$i;$j++) {
                    $starttimej = Carbon::parse($timeslotval[$j]['start_time'])->format('H:i:s');
                    $endtimej = Carbon::parse($timeslotval[$j]['end_time'])->format('H:i:s');
                    if($starttime <= $starttimej && $endtime >= $endtimej){
                        return $response;
                    }
                    elseif($starttime >=$starttimej && $starttime < $endtimej && $endtime > $endtimej){
                        return $response;
                    }
                    elseif($starttime <=$starttimej  && $endtime > $starttimej && $endtime < $endtimej){
                        return $response;
                    }
                    elseif($starttime <=$starttimej && $endtime > $starttimej && $endtime < $endtimej){
                        return $response;
                    }
                    elseif($starttime >= $starttimej && $starttime <=$endtimej && $endtime < $endtimej && $endtime > $starttimej){
                        return $response;
                    }else{
                        return ['status'=> true,'message'=>"success"];
                    }
                }
            }
        }
    }
}
