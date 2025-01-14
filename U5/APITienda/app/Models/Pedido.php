<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    //
    function usuario(){
        return $this->belongsTo(User::class);
    }
    function producto(){
        return $this->belongsTo(Producto::class);
    }
}
