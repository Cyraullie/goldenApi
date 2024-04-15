<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'level_id'];

    public function level() {
        return $this->belongsTo(Level::class, 'level_id');
    }

    public function variations() {
        return $this->hasMany(Variation::class);
    }
}