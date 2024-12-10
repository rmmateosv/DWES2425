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
<form action="{{route('modificarP',$p->id)}}" method="post" class="row g-3" enctype="multipart/form-data">
    @method('PUT')
        @csrf
        <div class="row-md-3">
            <label for="nombre" class="form-label" >Nombre</label>
            <input type="text" name="nombre" value="{{$p->nombre}}" class="form-control" placeholder="Nombre"/>
            @error('nombre')
                <p class="text-danger">{{$message}}</p>
            @enderror
        </div>
        <div class="row-md-1">
            <label for="precio" class="form-label" >Precio</label>
            <input type="number"  step="0.1" name="precio" value="{{$p->precio}}" class="form-control"/>
            @error('precio')
                <p class="text-danger">{{$message}}</p>
            @enderror
        </div>
        <div class="row-md-1">
            <label for="stock" class="form-label" >Stock</label>
            <input type="number" name="stock" value="{{$p->stock}}" class="form-control"/>
            @error('stock')
                <p class="text-danger">{{$message}}</p>
            @enderror
        </div>
        <div class="row-md-3">
            <label for="img" class="form-label" >Imagen</label>
            <input type="file" name="img" class="form-control"/>
            @error('img')
                <p class="text-danger">{{$message}}</p>
            @enderror
        </div>
        <div class="row-md-2">
            <button type="submit" name="modif" class="form-control" class="btn btn-outline-info">Modificar</button>
        </div>
</form>
    
@endsection