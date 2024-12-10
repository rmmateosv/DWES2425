<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginC extends Controller
{
    function login()
    {
        return view('login');
    }
    function loguear(Request $request)
    {
        //Validar
        $request->validate(
            [
                'email' => 'required|email:rfc,dns',
                'ps' => 'required'
            ]
        );
        //Crear array con us y ps
        $credenciales = ['email' => $request->email, 'password' => $request->ps];
        //Validación de credenciales
        if (Auth::attempt($credenciales)) {
            if (Auth::user()->perfil == 'A') {
                //Reinciamos la sesión
                $request->session()->regenerate();
                //Redirigimos a inicio
                return redirect()->route('inicio');
            } else {
                Auth::logout();
                return redirect()->route('login');
            }
        } else {
            return back()->with('mensaje', 'Datos Incorrectos');
        }
    }
    function vistaUsuarios()
    {
        $usuarios = User::where('perfil', 'A')->get();
        return view('usuarios/verUsuarios', compact('usuarios'));
    }
    function crearU(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'email' => 'required|unique:App\Models\User,email'
        ]);
        try {
            //code...
            $u = new User();
            $u->name = $request->nombre;
            $u->email = $request->email;
            $u->password = Hash::make('admin');
            $u->perfil = 'A';
            if ($u->save()) {
                return back()->with('mensaje', 'Usuario creado');
            } else {
                return back()->with('error', 'Error al crear el usuario');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', $th->getMessage());
        }
    }
    function borrarU(Request $request, $id)
    {
        try {
            //code...
            if (Auth::user()->id != $id) {
                $u = User::find($id);
                if ($u != null and $u->perfil == 'A') {
                    if ($u->delete()) {
                        return back()->with('mensaje', 'Usuario borrado');
                    } else {
                        return back()->with('error', 'Error al borrar el usuario');
                    }
                } else {
                    return back()->with('error', 'Usuario no existe o no es administrador');
                }
            } else {
                return back()->with('error', 'No te puedes borrar');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', $th->getMessage());
        }
    }
    function cerrar()
    {
        Auth::logout();
        return redirect()->route('inicio');
    }
}
