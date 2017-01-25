<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvpzList extends Model
{
    public $timestamps = false;

    protected $table = 'avpz_list';

    protected $fillable = ['id', 'title', 'downloadLink', 'downloadLinkExe'];
}
