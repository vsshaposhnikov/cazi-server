<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UrgentMessages extends Model
{
    public $timestamps = false;


    protected $table = 'urgent_messages';

    protected $fillable = [ 'id', 'title', 'content', 'createDate', 'creator', 'isPublished'];
}
