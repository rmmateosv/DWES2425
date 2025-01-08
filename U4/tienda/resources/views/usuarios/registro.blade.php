<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        
    <form action="{{route('registrar')}}" method="post" class="row g-3">
        @csrf
        <div class="row-md-3">
            <label for="nombre" class="form-label" >Nombre</label>
            <input type="text" name="nombre" value="{{old('nombre')}}" class="form-control"/>
            @error('nombre')
                <p class="text-danger">{{$message}}</p>
            @enderror
        </div>
        <div class="row-md-3">
            <label for="email" class="form-label" >Email</label>
            <input type="email" name="email" value="{{old('email')}}" class="form-control"/>
            @error('email')
                <p class="text-danger">{{$message}}</p>
            @enderror
        </div>
        <div class="row-md-3">
            <label for="ps" class="form-label" >Contraseña</label>
            <input type="password" name="ps" class="form-control"/>
            @error('ps')
                <p class="text-danger">{{$message}}</p>
            @enderror
        </div>
        <div class="row-md-3">
            <label for="ps2" class="form-label" >Confimar Contraseña</label>
            <input type="password" name="ps2" class="form-control"/>
            @error('ps2')
                <p class="text-danger">{{$message}}</p>
            @enderror
        </div>
        <div class="row-md-3">
            <button type="submit" name="crearU" value="crearU" class="btn btn-outline-secondary">Crear</button>
            <a href="{{route('login')}}" class="btn btn-outline-secondary">Volver</a>
        </div>
    </form>
    @if (session('mensaje'))
        {{session('mensaje')}}
    @endif
    </div>
</body>
</html>