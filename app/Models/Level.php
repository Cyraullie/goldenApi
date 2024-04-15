<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'group_element_id'];

    public function groupElement() {
        return $this->belongsTo(GroupElement::class, 'group_element_id');
    }

    public function elements() {
        return $this->hasMany(Element::class);
    }
}
