<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Concierto extends Model
{
    public function entradas(){
        return $this->hasMany(Entrada::class);
    }
}
