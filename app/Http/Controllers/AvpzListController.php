<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AvpzList;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AvpzListController extends Controller
{
    public function getAvpzList(){
        return response(AvpzList::all(), 200);
    }
}
