<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    public $timestamps = false;
    protected $table = 'tokens';
    protected $fillable = ['userId', 'token', 'createDate', 'expirationDate'];

    protected $hidden = ['id'];
}
