<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginC extends Controller
{
    function vistaLogin(){
        return view('usuarios/login');
    }
    function loguear(Request $request){
        //Validar
        $request->validate(
            [   'email' =>'required|email:rfc,dns',
                'ps'=>'required'
            ]
        );
        //Crear array con us y ps
        $credenciales = ['email'=>$request->email,'password'=>$request->ps];
        //Validación de credenciales
        if(Auth::attempt($credenciales)){
            //Reinciamos la sesión
            $request->session()->regenerate();
            //Redirigimos a inicio
            return redirect()->route('inicio');
        }
        else{
            return back()->with('mensaje','Datos Incorrectos');
        }
        
    }
    function vistaRegistro(){
        return view('usuarios/registro');
    }
    function registrar(Request $request){
        //Método que se llama desde el formulario de registro al pulsar en crear
        //Validar campos
        $request->validate([
            'nombre'=>'required',
            'email' =>'required|email:rfc,dns|unique:App\Models\User,email',
            'ps'=>'required|min:3|max:10',
            'ps2'=>'required|min:3|max:10|same:ps'
        ]);

        //Si no hay errores en las validaciones, creamos el usuario
        // y lo autenticamos
        $u=new User();
        //Rellenamos los campos del usuario con los datos del formulario
        $u->name=$request->nombre;
        $u->email=$request->email;
        $u->password = Hash::make($request->ps);
        //Crear usuario: HAce insert en users
        if($u->save()){
            //Autenticamos
            Auth::login($u);
            //Redirigimos a inicio
            return redirect()->route('inicio');
        }
        else{
            return back()->with('mensaje','Error, no se ha podido crear el usuario');
        }
    }
    function cerrarSesion(){
        Auth::logout();
        return redirect()->route('inicio');
    }
}
