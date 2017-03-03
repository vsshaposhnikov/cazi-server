<?php

namespace App\Http\Controllers;
use App\AvpzList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Respect\Validation\Validator as v;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
class UsersController extends Controller
{
    private function crateOrUpdateAvpz($avpz, $userId){
            DB::table('users_to_avpz')->where('userId', $userId)->delete();
            foreach ($avpz as $avpzId) {
                DB::table('users_to_avpz')->insert([['userId' => $userId, 'avpzId' => $avpzId]]);
            }
            return true;
    }

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
                'creationDate' => Carbon::today(),
            )
        );
        if($newUserInfo){
            return $newUserInfo;
        }
        else{ return false; }
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

        if($newUserInfo){
            $newUserInfo = User::where('id', $userInfo['id'])->get();
            return $newUserInfo;
        }
        else { return false; }
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
        $token = $request->input('token');
        if (Controller::checkToken($token)) {
            if (isset($userInfo['id'])) {
                $updatedUser = $this->updateUserInfo($userInfo);
                if ($this->crateOrUpdateAvpz($userInfo['avpzArray'], $userInfo['id']) or $updatedUser){
                    return response(!$updatedUser ? 'Оновлено тільки АВПЗ' : $updatedUser, 200);
                }
            } else {
                if ($this->isDuplicate($userInfo['email'], $userInfo['login'])) {
                    $newUser = $this->createUserInfo($userInfo);
                    if(!isset($userInfo['role']))
                        if($this->crateOrUpdateAvpz($userInfo['avpzArray'], $newUser['id'])){
                            if($this->successRegistrationMail($newUser['mail'], $newUser['login'])){
                                return response($newUser, 200);
                            }
                        }
                } else { return response('invalid email or login', 500); }
            }
        } else { return response('invalid token', 500); }
    }


    public function findUsers (Request $request){
        if(Controller::checkToken($request->input('token'))){
            $userInfo = $request->input('userInfo');
            if($userInfo['searchWord'] == null){
                User::where('id', '=<', 15)->get();
            }
            $pointUsers = User::where('login', 'LIKE', '%'.$userInfo['searchWord'].'%')
                ->orWhere('organization', 'LIKE', '%'.$userInfo['searchWord'].'%')
                ->orWhere('email', 'LIKE', '%'.$userInfo['searchWord'].'%')
                ->orWhere('firstName', 'LIKE', '%'.$userInfo['searchWord'].'%')
                ->orWhere('lastName', 'LIKE', '%'.$userInfo['searchWord'].'%')->get();
            return response( $pointUsers, 200);
        }
        else{
            return response('invalid token', 500);
        }
    }


    public function changePassword(Request $request){

        if(Controller::checkToken($request->input('token'))){
            $userInfo = $request->input('userInfo');
            $newPassword = password_hash($userInfo['newPassword'], PASSWORD_BCRYPT);
            $currentUser = $this->getCurrentUser($request->input('token'));
            if(password_verify($userInfo['oldPassword'], $currentUser->password)){
                $updatedPassword = User::where('id', $currentUser->id)->update(array('password' => $newPassword));
                if(count($updatedPassword) != 0){
                    return response('password changed', 200);
                }
                else{
                    return response('password not changed', 500);
                }
            }
            else{
                return response('old password is not correct', 200);
            }
        }
        else{
            return response('invalid token', 500);
        }

    }

    public function setActive(Request $request){
        if(Controller::checkToken($request->input('token'))){
            $activate = User::where('id', $request->input('id'))->update([
                'isActive' => 1,
                'lastVisit' => Carbon::now()
            ]);
            if($activate > 0)
            return response( 'successful activate', 200);
        }
        else{
            return response('invalid token', 500);
        }

    }

}
