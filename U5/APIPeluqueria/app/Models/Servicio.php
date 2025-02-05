<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    //
    function detalle_citas(){
        return $this->hasMany(Detalle_cita::class)->get();
    }
}
