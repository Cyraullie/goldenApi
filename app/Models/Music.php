<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    protected $table = 'musics';

    public $timestamps = false;

    protected $fillable = ['name', 'extension', 'filename'];
}