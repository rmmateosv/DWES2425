@extends('plantilla')

@if (session('mensaje'))
   @section('info')
    <h3 class="text-success">{{session('mensaje')}}</h3>
   @endsection
@endif
@if (session('error'))
   @section('error')
    <h3 class="text-danger">{{session('error')}}</h3>
   @endsection
@endif

@section('main')
    <table class="table">
        <thead>
            <tr>
                <td>Id</td>
                <td>Producto</td>
                <td>Precio Unitario</td>
                <td>Cantidad</td>
                <td>Total</td>
                <td>Imagen</td>
                <td>Eliminar</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($productosC as $p)
            <tr>
                <td>{{$p->id}}</td>
                <td>{{$p->producto->nombre}}</td>
                <td>{{$p->precioU}}</td>
                <td>{{$p->cantidad}}</td>
                <td>{{$p->cantidad*$p->precioU}}</td>
                <td><img src="{{asset('img/productos/'.$p->producto->imagen)}}" 
                    alt="{{$p->id}}" width="30px"></td>
                <td>
                    <form action="{{route('addCarrito')}}" method="post">
                        @csrf
                        <button type="submit" name="btnAdd" value="{{$p->id}}">
                            <img src="{{asset('img/cesta.png')}}" 
                            alt="cesta" width="30px">
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
@endsection