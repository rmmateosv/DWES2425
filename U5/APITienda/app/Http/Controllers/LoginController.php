<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    function login(Request $request){

    }
    function registro(Request $request){
        //Validar datos
        $request->validate([
            'nombre'=>'required',
            'email' =>'required|unique:App\Models\User,email',
            'ps'=>'required|min:3|max:10',
            'ps2'=>'required|min:3|max:10|same:ps'
        ]);
        try {
            //Crear usuario
            $u = new User();
            $u->name=$request->nombre;
            $u->email=$request->email;
            $u->password=Hash::make($request->ps);
            if($u->save()){
                return $u;
            }
            else{
                return response()->json('Error al crear el usuario',500);
            }
        } catch (\Throwable $th) {
            return response()->json('Error:'.$th->getMessage(),500);
        }
    }
    function logout(Request $request){
        
    }
}
