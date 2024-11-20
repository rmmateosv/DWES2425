<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginC extends Controller
{
    function vistaLogin(){
        return view('usuarios/login')
    }
    function loguear(){
        
    }
    function vistaRegistro(){
        echo 'Pantalla de registro';
    }
    function registrar(){
        
    }
    function cerrarSesion(){
        echo 'Cerrar sesión';
    }
}
