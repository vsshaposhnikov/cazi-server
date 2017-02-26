<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LegalBase extends Model
{
    public $timestamps = false;

    protected $table = 'legal_bases';

    protected $fillable = ['id', 'title', 'date', 'downloadLink'];
}
