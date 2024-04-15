<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Athlete extends Model
{
    public $timestamps = false;

    protected $fillable = ['firstname', 'group_athlete_id1', 'group_athlete_id2'];


    public function groupAthlete1() {
        return $this->belongsTo(GroupAthlete::class, 'group_athlete_id1');
    }

    public function groupAthlete2() {
        return $this->belongsTo(GroupAthlete::class, 'group_athlete_id2');
    }

    public function stateElements() {
        return $this->hasMany(StateElement::class);
    }
    
}

