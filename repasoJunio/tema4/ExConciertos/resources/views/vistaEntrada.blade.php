<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vista Entrada</title>
</head>
<body>
    <h2>Concierto:{{$concierto->titulo}}</h2>
    <h2>Aforo:{{$concierto->aforo}}</h2>
    <h2>PrecioEntrada:{{$concierto->precioEntrada}}</h2>
    <h2> <a href="{{route('rI')}}">Inicio </a> </h2>

    <form action="{{route('rV',$concierto->id)}}" method="post">
        <label for="email">Email</label>
        <input type="email" name="email" id="email"/>

        <label for="numEntradas">Nº de Entradas</label>
        <input type="number" name="numEntradas" id="numEntradas"/>
        <button type="submit" name="registrarV" id="registrarV">Registrar Venta</button>
    </form>
    

</body>
</html>