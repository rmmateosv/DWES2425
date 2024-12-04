<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        //return view('productos/verProductos',['productos'=>$productos]);
    }
    function addCarrito(Request $request)
    {
        //Comprueba si hay stock y en caso afirmativo inserta el 
        //producto en el carrito
        //Obtener los datos del producto
        //Equivale a select * from productos where id = idP
        $p = Producto::find($request->btnAdd);
        if ($p != null) {
            if ($p->stock > 0) {
                //Comprobamos si el producto está ya en la cesta
                $produtoC = Carrito::where('producto_id', $p->id)
                    ->where('user_id', Auth::user()->id)->first();
                if ($produtoC == null) {
                    //Crear producto en carrito
                    $produtoC = new Carrito();
                    $produtoC->producto_id = $p->id;
                    $produtoC->cantidad = 1;
                    $produtoC->precioU = $p->precio;
                    $produtoC->user_id = Auth::user()->id;
                } else {
                    //Incrementar en 1 la cantidad
                    $produtoC->cantidad += 1;
                    //Actualizamos el precio
                    $produtoC->precioU = $p->precio;
                }
                //Guardamos cambios: Hacemos un INSERT o un UPADTE
                if ($produtoC->save()) {
                    return back()->with('mensaje', 'Producto añadido a la cesta');
                } else {
                    return back()->with('error', 'No se ha añadio el producto  a la cesta');
                }
            } else {
                return back()->with('error', 'No hay stock del producto ' . $p->nombre);
            }
        } else {
            return back()->with('error', 'No existe el producto ' . $request->btnAdd);
        }
    }
    function verCesta()
    {
        //Obtener los productos en el carrito del usuario
        $productosC = Carrito::where('user_id', Auth::user()->id)->get();
        //Cargar la vista de la cesta
        return view('productos/verCesta', compact('productosC'));
    }
    function tratarCarrito(Request $request,$idP)
    {
        if (isset($request->btnBorrar)) {
            //Obtener el producto en el carrito a borrar
            $p = Carrito::find($request->btnBorrar);
            if ($p != null) {
                //Borrar de la tabla carrito
                if ($p->delete()) {
                    return back()->with('mensaje', 'Producto borrado del carrito');
                } else {
                    return back()->with('error', 'No se ha podido borrar el producto del carrito');
                }
            } else {
                return back()->with('error', 'El producto no está en el carrito');
            }
        }
        elseif(isset($request->cantidad) and $request->cantidad>=0){
            //Comprobar si se ha modificado la cantidad del producto
            $p= Carrito::find($idP);
            if($p->cantidad!=$request->cantidad){
                //Comprobar si hay stock
                if($p->producto->stock>=$request->cantidad){
                    //Modificar el producto en el carrito
                    $p->cantidad=$request->cantidad;
                    if($p->save()){
                        return back()->with('mensaje', 'Cantidad modificada');
                    }
                    else{
                        return back()->with('error', 'No se ha modificado la cantidad');
                    }
                }
                else{
                    return back()->with('error', 'No hay stock suficiente');
                }
            }
        }
        return back();
        
    }
    function crearPedido(Request $request){
        //Comprobar que hay stock y que los precios no han cambiado
        //Informar en caso necesario
        $carrito = Carrito::where('user_id',Auth::user()->id)->get();
        foreach($carrito as $c){
            //Comprobar si ha cambiado el precio
            if($c->precioU!=$c->producto->precio){
                return back()->
                with('error','Error, el producto '.$c->producto->nombre.'ha cambiado de precio. Borra el producto de la cesta para poder crear el pedido');
            }
            //Comprobar si hay stock
            if($c->cantidad>$c->producto->stock){
                return back()->
                with('error','Error, no hay stock para el producto '.$c->producto->nombre.'Borra el producto de la cesta para poder crear el pedido');
            }
        }
        //Convertir cada línea del carrito en un pedido
        //y vaciar el carrito
        //También hay que modficiar el stock
        //Vamos a hacer varios insert, varios update y varios delete
        //por lo que tenemos que hacer una transacción
        try {
            DB::transaction(function () {
               //Recuperamos carrito
               $carrito=Carrito::where('user_id',Auth::user()->id)->get(); 
               foreach($carrito as $c){
                    //Crear pedido
                    $p = new Pedido();
                    $p->user_id=Auth::user()->id;
                    $p->producto_id=$c->producto_id;
                    $p->cantidad=$c->cantidad;
                    $p->precioU=$c->producto->precio;
                    if($p->save()){
                        //Modificar stock del producto
                        $c->producto->stock-=$c->cantidad;
                        if($c->producto->save()){
                            //Borrar este producto del carrito
                            $c->delete(); 
                        }
                    }
               } 
            });
            return redirect()->route('pedidos')->with('mensaje','Pedidos creados');
        } catch (\Throwable $th) {
            return back()->with('error',$th->getMessage());
        }
        
    }
    function verPedidos(){
        //Recuperar los pedidos del usuario
        $pedidos=Pedido::where('user_id',Auth::user()->id)->get();
        //Redirigir a vista verPedidos
        return view('productos/verPedidos',compact('pedidos'));

    }
}
