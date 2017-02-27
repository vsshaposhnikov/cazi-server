<?php

namespace App\Http\Controllers;
/*SELECT
                                            avpz_nomenclatures.id, avpz_nomenclatures.title, avpz_nomenclatures.content, avpz_nomenclatures.address,
                                            avpz_nomenclatures.certificate, avpz_vendors.vendorName AS vendorName
                                            FROM avpz_nomenclatures
                                            JOIN avpz_vendors
                                            ON avpz_vendors.id = avpz_nomenclatures.vendorId
                                            WHERE avpz_nomenclatures.vendorId = 1*/
use Illuminate\Http\Request;
use App\AvpzNomenclature;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AvpzNumenclatureController extends Controller
{
    public function getAllAvpzNomenclatureUser(){
            $avpzNomenclature = DB::select('SELECT 
                                            avpz_nomenclatures.id, avpz_nomenclatures.title, avpz_nomenclatures.content, avpz_nomenclatures.address, 
                                            avpz_nomenclatures.certificate, avpz_vendors.vendorName AS vendorName 
                                            FROM avpz_nomenclatures 
                                            JOIN avpz_vendors 
                                            ON avpz_vendors.id = avpz_nomenclatures.vendorId 
                                          ');
            return response($avpzNomenclature, 200);
    }
    public function getAllAvpzNomenclature(Request $request){
        if (Controller::checkToken($request->input('token'))) {
            $avpzNomenclature = DB::select('SELECT 
                                            avpz_nomenclatures.id, avpz_nomenclatures.title, avpz_nomenclatures.content, avpz_nomenclatures.address, 
                                            avpz_nomenclatures.certificate, avpz_vendors.vendorName AS vendorName 
                                            FROM avpz_nomenclatures 
                                            JOIN avpz_vendors 
                                            ON avpz_vendors.id = avpz_nomenclatures.vendorId 
                                          ');
            return response($avpzNomenclature, 200);
        } else {
            return response('invalid token', 500);
        }
    }
    public function createOrUpdateAvpzNomenclature(Request $request){
        if (Controller::checkToken($request->input('token'))) {
            $nomenclatureInfo = $request->input('vendorInfo');
            if(isset($nomenclatureInfo['edit'])){
                if(AvpzNomenclature::where('id', $nomenclatureInfo['id'])->update([
                        'title' => $nomenclatureInfo['title'],
                        'content' => $nomenclatureInfo['content'],
                        'address' => $nomenclatureInfo['address'],
                        'certificate' => $nomenclatureInfo['certificate'],
                        'vendorId' => $nomenclatureInfo['vendorId']
                    ]) > 0)
                    return response(1, 200);
            }else{
                return response(AvpzNomenclature::create([
                    'title' => $nomenclatureInfo['title'],
                    'content' => $nomenclatureInfo['content'],
                    'address' => $nomenclatureInfo['address'],
                    'certificate' => $nomenclatureInfo['certificate'],
                    'vendorId' => $nomenclatureInfo['vendorId']
                ]), 200);
            }
        } else {
            return response('invalid token', 500);
        }
    }
    public function deleteAvpzNomenclature(Request $request){
        if (Controller::checkToken($request->input('token'))) {
            $avpzId = $request->input('id');
            $deleteAvpzNomenclature = AvpzNomenclature::where('id', $avpzId)->delete();
            if($deleteAvpzNomenclature > 0){
                return response(1, 200);
            }else{
                return response('not delete', 500);
            }
        } else {
            return response('invalid token', 500);
        }
    }
}
