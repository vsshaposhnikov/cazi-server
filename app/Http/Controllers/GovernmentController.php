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

}
