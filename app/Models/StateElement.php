<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StateElement extends Model
{
    public $timestamps = false;

    protected $fillable = ['athlete_id', 'variation_id', 'state'];

    public function athlete() {
        return $this->belongsTo(Athlete::class, 'athlete_id');
    }

    public function variation() {
        return $this->belongsTo(Variation::class, 'variation_id');
    }
}