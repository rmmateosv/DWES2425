<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductosC extends Controller
{
    function __construct()
    {
        //Comprobar si hay us logueado con Middelware Auth
        //$this->middleware('auth');
    }

    function verProductos(){
        return view('productos/verProductos');
    }
}