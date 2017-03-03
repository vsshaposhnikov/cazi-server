<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GovernmentOrganizations extends Model
{
    public $timestamps = false;

    protected $table = 'government_organizations';

    protected $fillable = ['id', 'organizationName'];
}
