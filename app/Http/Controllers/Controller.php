<?php

namespace App\Http\Controllers;
use App\Token;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getCurrentUser($token){
        $currentToken = Token::where('token', $token)->get();
        $currentUser = User::where('id', $currentToken[0]->userId)->get();
        return $currentUser[0];
    }
    public function checkToken($token){
        $tokenFromDb = Token::where('token', $token)->get();
        //$whoseToken = $this->getCurrentUser($token);
        if(count($tokenFromDb) == 1){
            if(Carbon::now() > $tokenFromDb[0]->expirationDate){
                Token::where('token', $tokenFromDb[0]->token)->delete();
                return false;
            }
            else{
                Token::where('token', $tokenFromDb[0]->token)->update(array('expirationDate' => Carbon::now()->addMinutes(60)));
                return true;
            }
        }
        else{
            return false;
        }
    }


}
