<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    public function concierto(){
        return $this->belongsTo(Concierto::class);
    }
}
