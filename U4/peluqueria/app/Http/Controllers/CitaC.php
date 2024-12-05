<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;

class CitaC extends Controller
{
    //

    function verCitas(){
        $citas=Cita::orderBy('fecha','DESC')->get();
        return view('citas',compact('citas'));
    }

    function modificarCita(Request $request){
        
    }
    function borrarCita(Request $request,$id){
        $cita=Cita::find($id);
        if($cita!=null){
            if($cita->delete()){
                return back()->with('mensaje','Cita con id '.$cita->id.' borrada');
            }
            else{
                return back()->with('mensaje','Error al borrar cita');
            }
        }
        else{
            return back()->with('mensaje','Error, cita no existe');
        }
    }
    function crearCita(Request $request){
        //Validar
        $request->validate([
            "fecha"=>"required",
            "hora"=>"required",
            "cliente"=>"required"
        ])  ; 

        $cita = new Cita();
        $cita->fecha=$request->fecha;
        $cita->hora=$request->hora;
        $cita->cliente=$request->cliente;
        if($cita->save()){
            return back()->with('mensaje','Cita con id '.$cita->id.' creada');
        }
        else{
            return back()->with('mensaje','Error, al crear la cita');
        }
    }
    function crearDetalle($id){
        return view('detalle');
    }
}
