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
<form action="{{route('crearP')}}" method="post" class="row g-3" enctype="multipart/form-data">
        @csrf
        <div class="col-md-3">
            <label for="nombre" class="form-label" >Nombre</label>
            <input type="text" name="nombre" value="{{old('nombre')}}" class="form-control" placeholder="Nombre"/>
            @error('nombre')
                <p class="text-danger">{{$message}}</p>
            @enderror
        </div>
        <div class="col-md-1">
            <label for="precio" class="form-label" >Precio</label>
            <input type="number"  step="0.1" name="precio" value="{{old('precio')}}" class="form-control"/>
            @error('precio')
                <p class="text-danger">{{$message}}</p>
            @enderror
        </div>
        <div class="col-md-1">
            <label for="stock" class="form-label" >Stock</label>
            <input type="number" name="stock" value="{{old('stock')}}" class="form-control"/>
            @error('stock')
                <p class="text-danger">{{$message}}</p>
            @enderror
        </div>
        <div class="col-md-3">
            <label for="img" class="form-label" >Imagen</label>
            <input type="file" name="img" class="form-control"/>
            @error('img')
                <p class="text-danger">{{$message}}</p>
            @enderror
        </div>
        <div class="col-md-1">
            <label for="img" class="form-label" > </label>
            <input type="submit" name="crear" class="form-control" value="Crear" class="btn btn-outline-info"/>
        </div>
</form>
    <table class="table">
        <thead>
            <tr>
                <td>Id</td>
                <td>Nombre</td>
                <td>Precio</td>
                <td>Stock</td>
                <td>Imagen</td>
                <td>Acciones</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $p)
            <tr>
                <td>{{$p->id}}</td>
                <td>{{$p->nombre}}</td>
                <td>{{$p->precio}}</td>
                <td>{{$p->stock}}</td>
                <td><img src="{{asset('storage/img/productos/'.$p->imagen)}}" 
                    alt="{{$p->id}}" width="30px"></td>
                <td>
                    <form action="{{route('borrarP',$p->id)}}" method="post">
                        @method('DELETE')
                        @csrf
                        <a class="btn btn-outline-info" href="{{route('vistaModificar',$p->id)}}">Modificar</a>
                        <button class="btn btn-outline-info" type="submit" name="borrarP" value="$p->id">Borrar
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
@endsection