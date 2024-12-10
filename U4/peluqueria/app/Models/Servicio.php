<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    function obtenerDetalle(){
        return $this->hasMany(DetalleCita::class)->get();
    }
}
