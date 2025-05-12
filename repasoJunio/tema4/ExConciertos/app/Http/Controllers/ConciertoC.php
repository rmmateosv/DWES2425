<?php

namespace App\Http\Controllers;

use App\Models\Concierto;
use App\Models\Entrada;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

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
        $r->validate(['email'=>'required', 'numEntradas'=>'required|numeric|min:1|max:4']);

        try {
            //chequear q hay entradas suficientes
            $c=Concierto::find($idC);
            if($c==null){
                throw new Exception('Concierto no existe');
            }
            if($c->aforo < $r->numEntradas){
                throw new Exception('No hay aforo suficiente');
            }

            //hacemos una transaacicon que cree la venta y actualice el aforo
            DB::transaction(function () use($r, $c) {
                //crear la entrada
                $e=new Entrada();
                $e->email=$r->email;
                $e->concierto_id=$c->id;
                $e->numEntradas=$r->numEntradas;
                $e->save(); //insert

                //update de aforo del concierto
                $c->aforo-=$r->numEntradas;
                $c->save(); //update
            });
        } catch (\Throwable $th) {
            return back()->with('mensaje', $th->getMessage());
        }

        return back()->with('mensaje', 'Se ha comprado la entreada con éxito');
    }

    function borrarM($idC){
        return 'pagina de borrar entradas del concierto '.$idC;
    }
}
