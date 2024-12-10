<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class ProductosC extends Controller
{
    function __construct()
    {
        //Comprobar si hay us logueado con Middelware Auth
        $this->middleware('auth');
    }
    function verProductos()
    {
        //REcuperamos los productos (equivale a select * from productos)
        //y los devuelve en un array
        $productos = Producto::all();
        return view('productos/verProductos', compact('productos'));
    }

    function crearP(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'precio' => 'required',
            'stock' => 'required',
            'img' => 'required'
        ]);
        try {
            //code...
            $p = new Producto();
            $p->nombre = $request->nombre;
            $p->precio = $request->precio;
            $p->stock = $request->stock;
            //Subir imagen
            $path = $request->file('img')->store('img/productos', 'public');
            $p->imagen = substr($path, 14, strlen($path));
            if ($p->save()) {
                return back()->with('mensaje', 'Producto creado');
            } else {
                return back()->with('error', 'Error al crear el producto');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', $th->getMessage());
        }
    }
    function vistaModificar($id)
    {
        try {
            $p = Producto::find($id);
            if ($p != null) {
                return view('productos/modificarProducto', compact('p'));
            } else {
                return back()->with('error', 'Producto no existe');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', $th->getMessage());
        }
    }
    function modificarP(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'precio' => 'required',
            'stock' => 'required'
        ]);
        try {
            //code...
            $p = Producto::find($id);
            if ($p != null) {
                $p->nombre = $request->nombre;
                $p->precio = $request->precio;
                $p->stock = $request->stock;

                
                if(isset($request->img)){
                    //Borrar imagen anterior
                    Storage::delete(['public/img/productos', $p->imagen]);
                    //Subir imagen
                    $path = $request->file('img')->store('img/productos', 'public');
                    $p->imagen = substr($path, 14, strlen($path));
                }
                if ($p->save()) {
                    return back()->with('mensaje', 'Producto modificado');
                } else {
                    return back()->with('error', 'Error al modificar el producto');
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', $th->getMessage());
        }
    }
    function borrarP(Request $request, $id)
    {
        try {
            $p = Producto::find($id);
            if ($p != null) {
                if (isset($p->pedidos()[0])) {
                    return back()->with('error', 'El producto tiene pedidos');
                } else {
                    if ($p->delete()) {
                        //Borrar imagen anterior
                        $f=Storage::delete(['public/img/productos', $p->imagen]);
                        return back()->with('mensaje', 'Producto borrado');
                    } else {
                        return back()->with('error', 'No se ha podido borrar');
                    }
                }
            } else {
                return back()->with('error', 'Producto no existe');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', $th->getMessage());
        }
    }
}
