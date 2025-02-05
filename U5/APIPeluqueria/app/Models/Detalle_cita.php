<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detalle_cita extends Model
{
    //
    function cita(){
        return $this->belongsTo(Cita::class);
    }
    function servicio(){
        return $this->belongsTo(Servicio::class);
    }
}
