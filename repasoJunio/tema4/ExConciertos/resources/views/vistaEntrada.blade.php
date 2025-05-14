<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vista Entrada</title>
</head>
<body>

    @if (session('mensaje'))
        <h2 style="color: red;">{{session('mensaje')}}</h2>    
    @endif
    <form action="{{route('rB',$concierto->id)}}" method="post">
        @method('DELETE')
        @csrf
         
        <h2>Concierto:{{$concierto->titulo}}<button type="submit" name="borrar" id="borrar">Borrar</button></h2>
        
        <h2>Aforo:{{$concierto->aforo}}</h2>
        <h2>PrecioEntrada:{{$concierto->precioEntrada}}</h2>
        <h2> <a href="{{route('rI')}}">Inicio </a> </h2>
    </form>
    <form action="{{route('rV',$concierto->id)}}" method="post">
        @csrf
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{old('email')}}"/>
            

        <label for="numEntradas">Nº de Entradas</label>
        <input type="number" name="numEntradas" id="numEntradas" value="{{old('numEntradas')}}"/>
        <button type="submit" name="registrarV" id="registrarV">Registrar Venta</button>
            @error('email')
                <h4 style="color: red;" >Debe rellenar el email</h4>
            @enderror

            @error('numEntradas')
            <h4 style="color: red;" >Obligatorio rellenar el campo con un valor entre 1 y 4</h4>
            @enderror
        
    </form>

    <div style="background-color: antiquewhite; width: 800px;">
        <h1 style="color: gray;">Entradas vendidas</h1>
        <table border="1">
            <tr>
                <td>Id</td>
                <td>Fecha</td>
                <td>Email</td>
                <td>Aforo</td>
            </tr>
            @foreach ($concierto->entradas() as $e)
                <tr>
                    <td>{{$e->id}}</td>
                    <td>{{$e->created_at}}</td>
                    <td>{{$e->email}}</td>
                    <td>{{$e->numEntradas}}</td>
                </tr>
            @endforeach
        </table>
    </div>
</body>
</html>