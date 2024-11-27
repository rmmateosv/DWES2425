<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="col g-3">
        <img src="{{asset('img/logo.jpg')}}" alt="logo">
    </div>
    <form action="{{route('loguear')}}" method="post" class="row g-3">
        @csrf
        <div class="row-md-3">
            <label for="email" class="form-label" >Email</label><br/>
            <input type="email" name="email" class="form-control"/>
        </div>
        <div class="row-md-3">
            <label for="ps" class="form-label" >Contraseña</label><br/>
            <input type="password" name="ps" class="form-control"/>
        </div>
        <div class="row-md-3">
            <button type="submit" name="login" class="btn btn-outline-secondary">Login</button>
            <a href="{{route('vistaRegistro')}}" class="btn btn-outline-secondary">Registrase</a>
        </div>
    </form>
    </div>
</body>
</html>