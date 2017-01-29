<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersToAvpz extends Model
{
    public $timestamps = false;

    protected $table = 'users_to_avpz';

    protected $fillable = ['id', 'userId', 'avpzId'];
}
