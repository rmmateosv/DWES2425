<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    //Relación 1:N entre producto y carrito
    //Un producto puede tener varios registros en carrito
    function productosCarrito(){
        return $this->hasMany(Carrito::class)->get();
    }
    //Relación 1:N entre producto y pedido
    //Un producto puede tener varios registros en pedidos
    function pedidos(){
        return $this->hasMany(Pedido::class)->get();
    }
}
