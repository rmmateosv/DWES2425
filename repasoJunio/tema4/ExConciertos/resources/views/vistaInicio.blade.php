<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vista Inicio</title>
</head>
<body>
    <form action="{{route('rE')}}" method="get">
        <h3>Selecciona un concierto</h3>
        @if (session('mensaje'))
            <h2 style="color: red;">{{session('mensaje')}}</h2>    
        @endif

        <select name="c">
            @foreach ($conciertos as $c)
                <option value="{{$c->id}}">{{$c->titulo}}</option>
            @endforeach
        </select>
        <button type="submit" name="btnEntradas" id="btnEntradas">Entradas</button>
        <h3>Listado de Conciertos</h3>

        <table border="1">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Titulo</td>
                    <td>Fechas</td> 
                    <td>Aforo</td>
                    <td>Precio</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($conciertos as $c)   
                <tr>
                    <td>{{$c->id}}</td>
                    <td>{{$c->titulo}}</td>
                    <td>{{$c->fecha}}</td>
                    <td>{{$c->aforo}}</td>
                    <td>{{$c->precioEntrada}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </form>
</body>
</html>