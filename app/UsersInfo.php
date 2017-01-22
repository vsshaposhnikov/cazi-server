<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersInfo extends Model
{
    public $timestamps = false;

    protected $table = 'users_information';

    protected $fillable = ['id', 'userId', 'firstName', 'lastName', 'organization', 'position', 'phone', 'creator', 'creationDate', 'isActive'];

    protected $hidden = ['id', 'userId', 'password'];
}
