<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use App\GovernmentOrganizations;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function getUserCreationInfo(Request $request){
        if(Controller::checkToken($request->input('token'))){
            $allUsers = User::all();
            $monthCounter = 0;
            $yearCounter = 0;
            foreach ($allUsers as $user){
                $creationDate = Carbon::parse($user->creationDate);
                if($creationDate->year == Carbon::now()->year){
                    $yearCounter++;
                }
                if($creationDate->month == Carbon::now()->month){
                    $monthCounter++;
                }
            }
            $countInfo[0] = $yearCounter;
            $countInfo[1] = $monthCounter;
            $countInfo[2] = User::where('creationDate', Carbon::today())->count();
            return response( $countInfo, 200);
        }
        else{
            return response('invalid token', 500);
        }

    }
    public function getActiveUsers(Request $request){
        if(Controller::checkToken($request->input('token'))){
            $allRegions = DB::select('SELECT * FROM regions');
            $activeUsers = null;
            foreach ($allRegions as $count => $region){
                $activeUsers['data'][$count] = User::whereRaw('isActive = ? and regionId = ?', [1, $region->id])->count();
                $activeUsers['labels'][$count] = $region->regionName;
            }

        return response($activeUsers, 200);
        }
        else{
            return response('invalid token', 500);
        }

    }
    public function getCountGovOrganizations(Request $request){
        if(Controller::checkToken($request->input('token'))){

            return response(GovernmentOrganizations::all()->count(), 200);
        }
        else{
            return response('invalid token', 500);
        }

    }
}
