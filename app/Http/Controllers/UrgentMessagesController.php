<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\UrgentMessages;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UrgentMessagesController extends Controller
{
    public function createOrUpdateUrgentMsg(Request $request){
        if (Controller::checkToken($request->input('token'))) {
            $urgentMsg = $request->input('urgentMsg');
            if($urgentMsg['editing']){
                $updateUrgentMsg = UrgentMessages::where('id', $urgentMsg['id'])->update([
                    'title' => $urgentMsg['title'],
                    'content' => $urgentMsg['content'],
                    'createDate' => Carbon::now(),
                    'creator' => $urgentMsg['creator'],
                    'isPublished' => false
                ]);
                if(count($updateUrgentMsg) > 0)
                return response('editing successful', 200);
            }else{
                $newUrgentMsg = UrgentMessages::create([
                    'title' => $urgentMsg['title'],
                    'content' => $urgentMsg['content'],
                    'createDate' => Carbon::now(),
                    'creator' => $urgentMsg['creator'],
                    'isPublished' => false
                ]);
                if(!empty($newUrgentMsg))
                return response($newUrgentMsg, 200);
            }
        } else {
            return response('invalid token', 500);
        }
    }
    public function publishUrgentMsg(Request $request){
        if (Controller::checkToken($request->input('token'))) {
            $urgentMsg = $request->input('urgentMsg');
            if($urgentMsg['publish']){
                $updateUrgentMsg = UrgentMessages::where('id', $urgentMsg['id'])->update([
                    'isPublished' => true
                ]);
                if(count($updateUrgentMsg) > 0)
                return response('publishing successful', 200);
            }
        } else {
            return response('invalid token', 500);
        }
    }
    public function deleteUrgentMsg(Request $request){
        if (Controller::checkToken($request->input('token'))) {
            $urgentMsg = $request->input('urgentMsg');
            $updateUrgentMsg = UrgentMessages::where('id', $urgentMsg['id'])->delete();
            if(count($updateUrgentMsg) > 0)
            return response('deleting successful', 200);
        } else {
            return response('invalid token', 500);
        }
    }

    public function getUrgentMsgList(Request $request){
        if (Controller::checkToken($request->input('token'))) {
            if($request->input('userView')){
            return response(UrgentMessages::where('isPublished', 1)->get(), 200);
            }else{
                return response(UrgentMessages::all(), 200);
            }
        } else {
            return response('invalid token', 500);
        }
    }

}
