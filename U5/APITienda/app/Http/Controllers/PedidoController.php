<?php

namespace App\Http\Controllers;

use App\Http\Resources\PedidoResource;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PedidoController
{

    public function pdf()
    {
       
        try {

            $numPed = Pedido::count();
            $numProd = DB::select('SELECT COUNT(*) as num FROM productos')[0]->num;
            $pvpMedio = Pedido::avg('precioU');

            $estadistica1 = Pedido::selectRaw('producto_id, SUM(cantidad) as cantidad')
                                    ->groupBy('producto_id')
                                    ->get();

            $estadistica2 = DB::select('SELECT p.nombre as producto, SUM(cantidad*precioU) as total 
                                        FROM productos p join pedidos ped on  ped.producto_id = p.id
                                        GROUP BY producto_id');

            $datosPDF = [
                'titulo' => 'INFORME DE PEDIDOS',
                'numPed' => $numPed,
                'numProd' => $numProd,
                'pvpMedio' => $pvpMedio,
                'e1' => $estadistica1,
                'e2' => $estadistica2
            ];

            $pdf = Pdf::loadView('pdf',$datosPDF);
            //return $pdf->stream('reporte.pdf');
            return $pdf->download('reporte.pdf');
            
        } catch (\Throwable $th) {
            return response()->json('Error:'.$th->getMessage(),500);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        try {
            //Devolver pedidos de usuario logueado
            //return User::find(Auth::user()->id)->pedidos();
            $pedidos= Pedido::where('user_id',Auth::user()->id)->get();
            return PedidoResource::collection($pedidos);
        } catch (\Throwable $th) {
            return response()->json('Error:'.$th->getMessage(),500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //VAlidaciones
        $request->validate([
            'producto'=>'required',
            'cantidad'=>'required'
        ]);
        //Crear pedido
        try {
            DB::transaction(function() use ($request){
                //Obtener el producto y validar stock
                $p = Producto::find($request->producto);
                if($p!=null and $p->stock>=$request->cantidad){
                    $pedido = new Pedido();
                    $pedido->producto_id=$p->id;
                    $pedido->cantidad = $request->cantidad;
                    $pedido->precioU = $p->precio;
                    $pedido->user_id=Auth::user()->id;
                    //Crear pedido
                    if($pedido->save()){
                        //Actualizar stock del producto
                        $p->stock-=$pedido->cantidad;
                        if($p->save()){
                           // return response()->json($pedido,200);;
                        }
                    }
                }
                else{
                    throw new Exception('El producto no existe o no hay stock');
                }
            });
            return response()->json('Pedido creado',200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json('Error:'.$th->getMessage(),500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        //
    }
}
