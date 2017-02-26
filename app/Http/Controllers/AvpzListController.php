<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
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
    public function createOrUpdateAvpz(Request $request){
        if (Controller::checkToken($request->input('token'))) {
            $avpzInfo = $request->input('avpzInfo');
            if($avpzInfo['createTitle'] == true){
                return response(AvpzList::create(['title' => $avpzInfo['title']]), 200);
            }else{
                if(AvpzList::where('id', $avpzInfo['id'])->update(['title' => $avpzInfo['title']]) > 0)
                    return response(1, 200);
            }
            if($request->file('file')){
                $file = $request->file('file');
                if($request->input('exe') == true){
                    $newZip = Storage::put(
                        'exeStorage/'.urlencode($file->getClientOriginalName()),
                        file_get_contents($file->getRealPath())
                    );
                    if($newZip){
                        $downloadUrl = asset('exeStorage/'.urlencode($file->getClientOriginalName()));
                        if(AvpzList::where('id', $request->input('id'))->update(['downloadLinkExe' => $downloadUrl]) > 0)
                            return response('uploaded', 200);
                    }else{
                        return response('not upload', 500);
                    }
                }else{
                    $newZip = Storage::put(
                        'avpzStorage/'.urlencode($file->getClientOriginalName()),
                        file_get_contents($file->getRealPath())
                    );
                    if($newZip){
                        $downloadUrl = asset('avpzStorage/'.urlencode($file->getClientOriginalName()));
                        if(AvpzList::where('id', $request->input('id'))->update(['downloadLink' => $downloadUrl]) > 0)
                            return response('uploaded', 200);
                    }else{
                        return response('not upload', 500);
                    }
                }
            }
        } else {
            return response('invalid token', 500);
        }
    }
    public function deleteAvpz(Request $request){
        if (Controller::checkToken($request->input('token'))) {
            $avpzId = $request->input('id');
            $deleteAvpz = AvpzList::where('id', $avpzId)->delete();
            if($deleteAvpz > 0){
                return response(1, 200);
            }else{
                return response('not delete', 500);
            }
        } else {
            return response('invalid token', 500);
        }
    }
    public function getFilesList (Request $request){
        if (Controller::checkToken($request->input('token'))) {
            $files = Storage::files('avpzStorage');
            return response($files, 200);
        } else {
            return response('invalid token', 500);
        }
    }
    public function deleteFiles (Request $request){
        if (Controller::checkToken($request->input('token'))) {
            if($request->input('oneFileDelete') == true){
                if(Storage::delete($request->input('fileName')))
                    return response('delete successful', 200);
            }else{
                if(Storage::delete($request->input('fileNamesArr')))
                    return response('delete successful', 200);
            }
        } else {
            return response('invalid token', 500);
        }
    }
}
