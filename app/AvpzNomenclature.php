<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvpzNomenclature extends Model
{
    public $timestamps = false;

    protected $table = 'avpz_nomenclatures';

    protected $fillable = ['id', 'title', 'content', 'address', 'vendorId', 'certificate'];
}
