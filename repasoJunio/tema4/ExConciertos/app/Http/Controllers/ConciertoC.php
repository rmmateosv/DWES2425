<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConciertoC extends Controller
{
    function inicioM(){
        return 'pagina inicio';
    }

    function entradasM($idC){
        return 'pagina de entradas del concierto '.$idC;
    }

    function venderM($idC){
    }

    function borrarM($idC){
        return 'pagina de borrar entradas del concierto '.$idC;
    }
}
