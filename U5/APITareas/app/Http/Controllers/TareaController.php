<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Recueperar todas las tareas
        try {
            $tareas = Tarea::all();
            return $tareas;
        } catch (\Throwable $th) {
           return response()->json('Error:'.$th->getMessage(),500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Crear tarea
        //VAlidar datos
        $request->validate(
            [
                'prioridad'=>'in:Alta,Media,Baja',
                'fecha'=>'required',
                'hora'=>'required',
                'descripcion'=>'required'
            ]
        );
        try {
            //Crear un objeto tarea
            $t = new Tarea();
            if(isset($request->prioridad)){
                $t->prioridad = $request->prioridad;
            }
            $t->fecha = $request->fecha;
            $t->hora = $request->hora;
            $t->descripcion = $request->descripcion;
            if($t->save()){
                return response()->json(['mensaje'=>'Tarea Creada','tarea'=>$t],201);
            }
            else{
                return response()->json('Error:NO SE HA CREADO LA TAREA',500);
            }
        } catch (\Throwable $th) {
            return response()->json('Error:'.$th->getMessage(),500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarea $tarea)
    {
        // Mostrar una tarea
        try {
            return $tarea;
        } catch (\Throwable $th) {
            return response()->json('Error:'.$th->getMessage(),500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tarea $tarea)
    {
        //Modificar tarea
        //VAlidar datos
        $request->validate(
            [
                'prioridad'=>'in:Alta,Media,Baja'
            ]
        );

        try {
            //code...
            if(isset($request->fecha) and $tarea->fecha != $request->fecha){
                $tarea->fecha = $request->fecha;
            }
            if(isset($request->hora) and $tarea->hora != $request->hora){
                $tarea->hora = $request->hora;
            }
            if(isset($request->descripcion) and $tarea->descripcion != $request->descripcion){
                $tarea->descripcion= $request->descripcion;
            }
            if(isset($request->prioridad) and $tarea->prioridad != $request->prioridad){
                $tarea->prioridad= $request->prioridad;
            }
            if(isset($request->finalizada) and $tarea->finalizada != $request->finalizada){
                $tarea->finalizada= $request->finalizada;
            }
            //Guardamos cambios
            if($tarea->save()){
                return response()->json(['mensaje'=>'Tarea Modificada','tarea'=>$tarea],200);
            }
            else{
                return response()->json('Error:NO SE HA MODIFCADO LA TAREA',500);
            }
            
        } catch (\Throwable $th) {
            return response()->json('Error:'.$th->getMessage(),500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarea $tarea)
    {
        //Borrar tarea
        try {
            if($tarea->delete()){
                return response()->json('Tarea Borrada',204);
            }
            
        } catch (\Throwable $th) {
            return response()->json('Error:'.$th->getMessage(),500);
        }
    }
}
