<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    //
    function pedidos(){
        return $this->hasMany(Pedido::class)->get();
    }
}
