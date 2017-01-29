<?php

namespace App\Http\Controllers;

use App\UsersInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Respect\Validation\Validator as v;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
class UsersController extends Controller
{
    private function createUserInfo ($userInfo){
        $newUserInfo = User::create(
            array(
                'login' => $userInfo['login'],
                'password' => password_hash('11111', PASSWORD_BCRYPT),
                'email' => $userInfo['email'],
                'role' => isset($userInfo['role']) ? $userInfo['role'] : $userInfo['role'] = 'user',
                'lastVisit' => null,
                'firstName' => $userInfo['firstName'],
                'lastName' => $userInfo['lastName'],
                'organization' => $userInfo['organization'],
                'position' => $userInfo['position'],
                'phone' => $userInfo['phone'],
                'creator' => $userInfo['creator'],
                'isActive' => 1,
                'creationDate' => Carbon::now(),
            )
        );
        if($newUserInfo){
            return $newUserInfo;
        }
        else{
            return false;
        }
    }

    private function updateUserInfo ($userInfo){
        $newUserInfo = User::where('id', $userInfo['id'])->update(
            array(
                'id' => $userInfo['id'],
                'login' => $userInfo['login'],
                'email' => $userInfo['email'],
                'firstName' => $userInfo['firstName'],
                'lastName' => $userInfo['lastName'],
                'organization' => $userInfo['organization'],
                'position' => $userInfo['position'],
                'phone' => $userInfo['phone'],
                'creator' => $userInfo['creator'],
            )
        );
        if($newUserInfo != 0){
            $newUserInfo = User::where('id', $userInfo['id'])->get();
            return $newUserInfo;
        }
        else{
            return false;
        }
    }

    private function isDuplicate($email, $login){
        if(v::email()->validate($email)){
            if(count(User::where('email', $email)->get()) == 0){
                if(count(User::where('login', $login)->get()) == 0){
                    return true;
                }
            }
        }
        else{
            return false;
        }
    }

    public function createOrUpdateUser(Request $request) {
        $userInfo = $request->input('userInfo');
        if (Controller::checkToken($userInfo['token'])) {
            if (isset($userInfo['id'])) {
                return response($this->updateUserInfo($userInfo), 200);
            } else {
                if ($this->isDuplicate($userInfo['email'], $userInfo['login'])) {
                    $newUser = $this->createUserInfo($userInfo);
                    if ($newUser) {
                        foreach ($userInfo['avpzArray'] as $avpzId) {
                            DB::table('users_to_avpz')->insert([['userId' => $newUser['id'], 'avpzId' => $avpzId]]);
                        }
                    }
                    return response($newUser, 200);
                } else {
                    return response('invalid email or login', 500);
                }
            }
        } else {
            return response('invalid token', 500);
        }
    }

    public function getAllUsers(Request $request){
        $userInfo = $request->input('userInfo');
        if(Controller::checkToken($userInfo['token'])){
            $foundUsers = User::all();
            if(sizeof($foundUsers) != 0){
                return response($foundUsers, 200);
            }
            else{
                return response('no users on this data', 500);
            }
        }
        else{
            return response('invalid token', 500);
        }
    }
}
