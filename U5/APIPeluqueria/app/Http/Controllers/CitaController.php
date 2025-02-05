<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       try {
        //code...
        return Cita::all();
       } catch (\Throwable $th) {
        //throw $th;
        return response()->json('Error:'.$th);
       }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'fecha'=>'required',
            'hora'=>'required',
            'cliente'=>'required'
        ]);
        try {
            //code...
            $c = new Cita();
            $c->fecha = $request->fecha;
            $c->hora = $request->hora;
            $c->cliente = $request->cliente;
            if($c->save()){
                return $c;
            }
            else{
                return response()->json('Error al crear la cita');
            }
        } catch (\Throwable $th) {
            return response()->json('Error:'.$th->getMessage());
        }
    }

    function detalleCita(Request $request){
        $request->validate([
            'id'=>'required'
        ]);
        try {
            //code...
            $c = Cita::find($request->id);
            $citas = $c->detalle_citas();
            if(sizeof($citas)==0){
                throw new Exception('No hay ningún servicio en esta cita');
            }
            return $c->detalle_citas();
           } catch (\Throwable $th) {
            //throw $th;
            return response()->json('Error:'.$th->getMessage());
           }

    }

    /**
     * Display the specified resource.
     */
    public function show(Cita $cita)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cita $cita)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cita $cita)
    {
        //
    }
}
