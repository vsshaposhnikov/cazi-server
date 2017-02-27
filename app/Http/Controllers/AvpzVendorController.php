<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AvpzVendors;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AvpzVendorController extends Controller
{
    public function getAllAvpzVendors(Request $request){
        if (Controller::checkToken($request->input('token'))) {
            return response(AvpzVendors::all(), 200);
        } else {
            return response('invalid token', 500);
        }
    }
    public function createOrUpdateAvpzVendor(Request $request){
        if (Controller::checkToken($request->input('token'))) {
            $vendorInfo = $request->input('vendorInfo');
            if(isset($vendorInfo['edit'])){
                if(AvpzVendors::where('id', $vendorInfo['id'])->update([
                        'vendorName' => $vendorInfo['vendorName']
                    ]) > 0)
                    return response(1, 200);
            }else{
                return response(AvpzVendors::create([
                    'vendorName' => $vendorInfo['vendorName']
                ]), 200);
            }
        } else {
            return response('invalid token', 500);
        }
    }
    public function deleteAvpzVendor(Request $request){
        if (Controller::checkToken($request->input('token'))) {
            $avpzId = $request->input('id');
            $deleteAvpzVendor = AvpzVendors::where('id', $avpzId)->delete();
            if($deleteAvpzVendor > 0){
                return response(1, 200);
            }else{
                return response('not delete', 500);
            }
        } else {
            return response('invalid token', 500);
        }
    }
}
