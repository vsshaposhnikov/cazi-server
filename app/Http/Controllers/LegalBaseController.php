<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LegalBase;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class LegalBaseController extends Controller
{
    public function getLegalBase(){
        $legalBase = LegalBase::all();
        return response($legalBase, 200);
    }
}
