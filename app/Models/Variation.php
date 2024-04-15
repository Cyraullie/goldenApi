<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'element_id'];

    public function element() {
        return $this->belongsTo(Element::class, 'element_id');
    }

    public function stateElements() {
        return $this->hasMany(StateElement::class);
    }
}
