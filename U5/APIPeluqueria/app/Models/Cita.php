<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    function detalle_citas(){
        return $this->hasMany(Detalle_cita::class)->get();
    }
}
