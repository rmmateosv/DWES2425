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
<form action="{{route('crearU')}}" method="post" class="row g-3" enctype="multipart/form-data">
        @csrf
        <div class="col-md-3">
            <label for="nombre" class="form-label" >Nombre</label>
            <input type="text" name="nombre" value="{{old('nombre')}}" class="form-control" placeholder="Nombre"/>
            @error('nombre')
                <p class="text-danger">{{$message}}</p>
            @enderror
        </div>
        <div class="col-md-3">
            <label for="email" class="form-label" >Email</label>
            <input type="email"  name="email" value="{{old('email')}}" class="form-control"/>
            @error('email')
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
                <td>Email</td>
                <td>Perfil</td>
                <td>Acciones</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $u)
            <tr>
                <td>{{$u->id}}</td>
                <td>{{$u->name}}</td>
                <td>{{$u->email}}</td>
                <td>{{$u->perfil}}</td>
                <td>
                    <form action="{{route('borrarU',$u->id)}}" method="post">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-outline-info" type="submit" name="borrarP" value="$p->id">Borrar
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
@endsection