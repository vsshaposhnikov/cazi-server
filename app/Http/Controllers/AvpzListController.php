<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AvpzList;
use Illuminate\Support\Facades\DB;
use App\UsersToAvpz;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AvpzListController extends Controller
{
    public function getAvpzList(Request $request){
        if (Controller::checkToken($request->input('token'))) {
            return response(AvpzList::all(), 200);
        } else {
            return response('invalid token', 500);
        }
    }
    public function getAvpzListByUser(Request $request){
        $userInfo = $request->input('userInfo');
        if (Controller::checkToken($request->input('token'))) {
            return response(DB::select('
                                        SELECT *
                                        FROM avpz_list 
                                        JOIN users_to_avpz 
                                        ON users_to_avpz.avpzId = avpz_list.id
                                        AND users_to_avpz.userId = ?', [$userInfo['id']]), 200);
        } else {
            return response('invalid token', 500);
        }
    }
}
