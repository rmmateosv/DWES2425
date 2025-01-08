<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Prestamo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDOException;

class PrestamoC extends Controller
{
    //
    function ver(){
        //Obtener los préstamos de la BD
        $prestamos = Prestamo::all();
        //Cargar la vista
        return view('verP',compact('prestamos'));
    }
    function crear(){
        //Recuperar los libros
        $libros = Libro::all();
        //Cargar vista crear préstamo
        return view('crearP',compact('libros')); 
    }
    function modificar($id){
        $p = Prestamo::find($id);
        $libros = Libro::all();
        return view('modificarP',compact('p','libros'));
    }
    function insertar(Request $r){
        $r->validate([
            'fecha'=>'required',
            'libro'=>'required',
            'cliente'=>'required',
        ]);
        //Chequear ejemplares
        $l = Libro::find($r->libro);
        if($l!=null and $l->numEjemplares>0){
            //Chequear que el cliente no tiene préstamos pendientes
            $pendientes = Prestamo::where('nombreCliente',$r->cliente)
            ->where('fechaDevolucion',null)->get();
            if(sizeof($pendientes)>0){
                return back()->with('mensaje',
            'Error, el cliente tiene libros sin devolver');
            }
            else{
                //Registrar préstamos y actualizar nº de ejemplares
                $error=false;
                $mensaje="";
                try{
                    DB::transaction(function () use($r,$error) {
                        //Insert
                        $p = new Prestamo();
                        $p->fecha=$r->fecha;
                        $p->libro_id=$r->libro;
                        $p->nombreCliente=$r->cliente;
                        if($p->save()){
                            //Modicar el nº de ejemplares
                            $p->libro->numEjemplares=$p->libro->numEjemplares-1;
                            if(!$p->libro->save()){
                                $error=true;
                            }
                        }
                        else{
                            $error=true;
                        }                        
                    });
                }
                catch(Exception $e){
                    $error=true;
                    $mensaje=$e->getMessage();
                }
                finally{
                    if($error){
                        return back()->with('mensaje',
                        $mensaje);
                    }
                    else{
                       return redirect()->route('rutaVer');
                    }
                }
            }
        }
        else{
            return back()->with('mensaje',
            'Error, libro no existe o no hay ejemplares para prestar');
        }
    }
    function actualizar(Request $r,$id){
        $r->validate([
            'fecha'=>'required',
            'libro'=>'required',
            'cliente'=>'required',
        ]);
        //Chequear si se cambia el libro para        
        //chequear si hay ejemplares
        $p = Prestamo::find($id);
        $libroAntiguo = $p->libro_id;
        if($p->libro_id!=$r->libro){
            //Chequear ejemplares de libro nuevo
            $l = Libro::find($r->libro);
            if($l==null or $l->numEjemplares<=0){
                return back()->with('mensaje','Libro no existe o no hay ejemplares');
            }
        }        
        //Cambiar los datos del préstamo por los nuevos
        $p->fecha = $r->fecha;
        $p->nombreCliente = $r->cliente;
        $p->fechaDevolucion = $r->fechaD;
        $p->libro_id = $r->libro;        
        //Registrar préstamos y actualizar nº de ejemplares
        $error=false;
        $mensaje="";
        try{
            DB::transaction(function () use($p,$error,$libroAntiguo) {   
                //Update prestamo             
                if($p->save()){
                    if($p->libro_id!=$libroAntiguo){
                        //Modicar el nº de ejemplares del nuevo
                        $p->libro->numEjemplares=$p->libro->numEjemplares-1;
                        if(!$p->libro->save()){
                            $error=true;
                        }
                        //Update del libro antiguo
                        $liA = Libro::find($libroAntiguo);
                        $liA->numEjemplares++;
                        if(!$liA->save()){
                            $error=true;
                        }
                     }
                }
                else{
                    $error=true;
                }                        
            });
        }
        catch(Exception $e){
            $error=true;
            $mensaje=$e->getMessage();
        }
        finally{
            if($error){
                return back()->with('mensaje',
                $mensaje);
            }
            else{
                return redirect()->route('rutaVer');
            }
        }
            
    }
}
