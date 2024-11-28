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
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- menú e info us -->
                        <li class="nav-item"><a href="{{route('inicio')}}" class="nav-link" >Productos</a></li>
                        <li class="nav-item"><a href="" class="nav-link" >Pedidos</a></li>
                        <li class="nav-item"><a href="" class="nav-link" >Cesta</a></li>
                    </ul>
                    <div  class="d-flex">
                        <span  class="nav-link">{{Auth::user()->name}}</span>
                        <a href="{{route('cerrar')}}" class="nav-link">Salir</a>
                    </div>
                </div>
            </div>
        </nav>
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