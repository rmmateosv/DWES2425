<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginC extends Controller
{
    function vistaLogin(){
        return view('usuarios/login');
    }
    function loguear(){
        echo 'proceso de logueo';
    }
    function vistaRegistro(){
        return view('usuarios/registro');
    }
    function registrar(Request $request){
        //Método que se llama desde el formulario de registro al pulsar en crear
        //Validar campos
        $request->validate([
            'nombre'=>'required'
        ]);
    }
    function cerrarSesion(){
        echo 'Cerrar sesión';
    }
}
