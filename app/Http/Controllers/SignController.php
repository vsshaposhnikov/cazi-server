<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Token;
use Carbon\Carbon;
class SignController extends Controller
{
    private function isActive($currentUser){
        if($currentUser->isActive){
            return true;
        } else {
            return false;
        }
    }
    private function userVerify($currentUser, $password){
        if(password_verify($password, $currentUser->password)){
            $generatedToken = password_hash($currentUser->email, PASSWORD_BCRYPT);
            Token::create(
                array(
                    'userId' => $currentUser->id,
                    'token' => $generatedToken,
                    'createDate' => Carbon::now(),
                    'expirationDate' => Carbon::now()->addMinutes(60),
                )
            );
            User::where('id', $currentUser->id)->update([
                'lastVisit' => Carbon::now()
            ]);
            $currentUser->token = $generatedToken;
            return $currentUser;
        }
        else{
            return 'wrong credentials';
        }
    }

    public function login(Request $request){
        if($request->input('login')){
            $login = $request->input('login');
            $findUser = User::where('login', $login)->get();
            if(sizeof($findUser) != 0){
                if($this->isActive($findUser[0]))   {
                    $lastVisit = new Carbon($findUser[0]->lastVisit);
                    if($lastVisit->addDays(7) >  Carbon::now()) {
                    return response($this->userVerify($findUser[0], $request->input('password')), 200);
                    } else {
                        if(User::where('id', $findUser[0]->id)->update(['isActive' => 0]) > 0)
                        return response('account blocked', 200);
                    }
                } else { return response('account notActive', 200); }
            }
            else{
                return response('wrong credentials', 500);
            }
        }
    }

    public function logout(Request $request){
        if($request->input('token')){
            $token = $request->input('token');
            if(Token::where('token', $token)->delete() != 0){
                return response('token destroyed', 200);
            }
            else{
                return response('token not destroyed', 500);
            }

        }
    }

}
