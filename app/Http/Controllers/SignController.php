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
    public function login(Request $request){
        if($request->input('login')){
            $login = $request->input('login');
            $findUser = User::where('login', $login)->get();
            if(sizeof($findUser) != 0){
                $password = $request->input('password');
                if(password_verify($password, $findUser[0]->password)){
                    $generatedToken = password_hash($findUser[0]->email, PASSWORD_BCRYPT);
                    Token::create(
                        array(
                            'userId' => $findUser[0]->id,
                            'token' => $generatedToken,
                            'createDate' => Carbon::now(),
                            'expirationDate' => Carbon::now()->addMinutes(60),
                        )
                    );
                    $findUser[0]->token = $generatedToken;
                    return response($findUser[0], 200);
                }
                else{
                    return response('wrong credentials', 500);
                }
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
