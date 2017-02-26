<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LegalBase;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class LegalBaseController extends Controller
{
    public function getLegalBase(){
        $legalBase = LegalBase::all();
        return response($legalBase, 200);
    }
    public function createOrUpdateLegalBase(Request $request){
        if (Controller::checkToken($request->input('token'))) {
            $legalBaseInfo = $request->input('legalBaseInfo');
            if(isset($legalBaseInfo['edit'])){
                if(LegalBase::where('id', $legalBaseInfo['id'])->update([
                        'title' => $legalBaseInfo['title'],
                        'date' => $legalBaseInfo['date']
                    ]) > 0)
                    return response(1, 200);
            }else{
                return response(LegalBase::create([
                    'title' => $legalBaseInfo['title'],
                    'date' => $legalBaseInfo['date']
                ]), 200);
            }
        } else {
            return response('invalid token', 500);
        }
    }
    public function deleteLegalBase(Request $request){
        if (Controller::checkToken($request->input('token'))) {
            $legalBaseInfo = $request->input('legalBaseInfo');
            $deleteLegal = LegalBase::where('id', $legalBaseInfo['id'])->delete();
            if($deleteLegal > 0){
                return response(1, 200);
            }else{
                return response('not delete', 500);
            }
        } else {
            return response('invalid token', 500);
        }
    }

    public function uploadLegalBaseAttachment(Request $request){
        if (Controller::checkToken($request->input('token'))) {
            $file = $request->file('file');
            $newZip = Storage::put(
                'legalAttachmentStorage/'.urlencode($file->getClientOriginalName()),
                file_get_contents($file->getRealPath())
            );
            if($newZip){
                $downloadUrl = asset('legalAttachmentStorage/'.urlencode($file->getClientOriginalName()));
                if(LegalBase::where('id', $request->input('id'))->update(['downloadLink' => $downloadUrl]) > 0)
                    return response('uploaded', 200);
            }else{
                return response('not upload', 500);
            }
        } else {
            return response('invalid token', 500);
        }
    }


}
