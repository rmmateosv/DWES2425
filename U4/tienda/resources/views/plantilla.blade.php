<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tienda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>
<body>
    <div class="container">
        <div class="rosa">
            <!-- menú e info us -->
            <ul>
                <li><a href="{{route('inicio')}}">Productos</a></li>
                <li><a href="">Pedidos</a></li>
                <li><a href="">Cesta</a></li>
                <li>{{Auth::user()->name}}</li>
                <li><a href="">Salir</a></li>
            </ul>
        </div>
        <div>
            <!-- mensajes -->
            @yield('error')
            @yield('info')
        </div>
        <div>
            <!-- main -->
            @yield('main')
        </div>
    </div>
</body>
</html>