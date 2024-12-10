<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleCita extends Model
{
    //
    function cita(){
        return $this->belongsTo(Cita::class);
    }
    function obtenerServicio(){
        return $this->belongsTo(Servicio::class,'servicio_id','id');
    }
    
}
