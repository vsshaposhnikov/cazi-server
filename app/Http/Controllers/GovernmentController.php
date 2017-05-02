<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GovernmentOrganizations;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Regions;
use App\AvpzVendors;
class GovernmentController extends Controller
{
    public function getGovOrganizationList(Request $request){
        if (Controller::checkToken($request->input('token'))) {
            return response(GovernmentOrganizations::all(), 200);
        } else {
            return response('invalid token', 500);
        }
    }

    public function createGovOrganization(Request $request){
        if (Controller::checkToken($request->input('token'))) {
            $newGovOrganization = GovernmentOrganizations::create([
                'organizationName' => $request->input('organizationName')
            ]);
            if($newGovOrganization){return response($newGovOrganization, 200);}
            else{return response('government organization not created', 500);}
        } else {
            return response('invalid token', 500);
        }
    }

}
