<?php

namespace App\Http\Controllers;

use App\Models\Concierto;
use Illuminate\Http\Request;

class ConciertoC extends Controller
{
    function inicioM(){
        $conciertos=Concierto::orderBy('titulo')->get();
        //Otra forma de ponerlo return view('vistaInicio',['conciertos'=>$conciertos]);
        return view('vistaInicio',compact('conciertos'));
    }

    function entradasM(Request $r){
        //obtenemos los datos del concierto
        $concierto=Concierto::find($r->c);
        
        if($concierto == null){
            return 'El concierto no existe';
        }
        return view('vistaEntrada',compact('concierto'));
    }

    function venderM(Request $r,$idC){

        if(){

        }

    }

    function borrarM($idC){
        return 'pagina de borrar entradas del concierto '.$idC;
    }
}
