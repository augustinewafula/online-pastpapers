<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pastpaper extends Model
{
    public function unit()
    {
        return $this->belongsTo('App\Unit', 'unit_id');
    }
}
