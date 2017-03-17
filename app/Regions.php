<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regions extends Model
{
    public $timestamps = false;
    protected $table = 'regions';
    protected $fillable = ['id', 'regionName'];
}
