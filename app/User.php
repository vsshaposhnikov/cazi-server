<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model
{
    public $timestamps = false;


    protected $table = 'users';

    protected $fillable = [ 'id', 'login', 'password', 'role',
                            'email', 'lastVisit', 'creator', 'lastName',
                            'firstName', 'isActive', 'phone', 'position', 'organization', 'creationDate', 'govId', 'vendorId', 'regionId'];

    protected $hidden = ['password'];
}
