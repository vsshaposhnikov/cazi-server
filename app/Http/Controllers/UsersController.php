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
    private function createOrUpdateUserInfo ($userInfo, $newUserId){
        $newUserInfo = UsersInfo::create(
            array(
                'userId' => $newUserId,
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
            return 'userInfo did not create';
        }
    }
    public function createOrUpdateUser(Request $request){

        if(v::email()->validate($request->input('email'))){
            $email = $request->input('email');
            $userInfo = $request->input('userInfo');
            $password = password_hash($request->input('password'), PASSWORD_BCRYPT);
            $login = $request->input('login');
            $duplicateEmail = User::where('email', $email)->get();
            $loginEmail = User::where('login', $login)->get();
            if($request->input('id')){
                if(Controller::checkToken($request->input('token'))){
                    $userId = $request->input('id');
                    $updatedUser = User::where('id', $userId)->update(
                        array(
                            'login' => $login,
                            'email' => $email,
                            'password' => $password
                        )
                    );
                    if ($updatedUser != 0) {
                        return response(User::where('id', $userId)->get(), 200);
                    } else {
                        return response('user did not update', 500);
                    }
                }
            }
            else{
                if(sizeof($duplicateEmail) == 0) {
                    if (sizeof($loginEmail) == 0) {
                        $newUser = User::create(
                            array(
                                'login' => $login,
                                'password' => $password,
                                'email' => $email,
                                'role' => 'user',
                                'lastVisit' => null
                            )
                        );
                        if($newUser){
                            $newUser['userInfo'] = $this->createOrUpdateUserInfo($userInfo, $newUser['id']);
                        }
                        return response($newUser, 200);
                    }
                    else{
                        return response('duplicate login', 500);
                    }
                }
                else{
                    return response('duplicate email', 500);
                }
            }
        }
        else{
            return response('invalid email', 500);
        }
    }
    public function getAllUsers(Request $request){

        if(Controller::checkToken($request->input('token'))){
            $foundUsers = DB::select('
SELECT * FROM users LEFT OUTER JOIN users_information ON users.id= users_information.userId
');
            if(sizeof($foundUsers) != 0){
                return response($foundUsers, 200);
            }
            else{
                return response('no users on this merchant point', 500);
            }
        }
        else{
            return response('invalid token', 500);
        }
    }
}
