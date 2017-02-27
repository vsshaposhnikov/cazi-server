<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvpzVendors extends Model
{
    public $timestamps = false;

    protected $table = 'avpz_vendors';

    protected $fillable = ['id', 'vendorName'];
}
