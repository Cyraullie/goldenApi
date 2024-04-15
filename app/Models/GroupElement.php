<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupElement extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];

    public function levels()
    {
        return $this->hasMany(Level::class);
    }
}