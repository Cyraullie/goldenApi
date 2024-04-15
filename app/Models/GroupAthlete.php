<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupAthlete extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];
}