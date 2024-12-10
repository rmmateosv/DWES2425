<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>CITAS</h1>
    <h2>Crear Cita</h2>
    <form action="{{route('crearC')}}" method="post">
        @csrf
        <input type="date" name="fecha" value="{{date('Y-m-d')}}"/>
        @error('fecha')
            <p style="color:red;">Rellena Fecha</p>
        @enderror
        <input type="time" name="hora" value="{{date('H:i')}}"/>
        @error('hora')
        <p style="color:red;">Rellena Hora</p>
        @enderror
        <input type="text" name="cliente" placeholder="Cliente"/>
        @error('cliente')
        <p style="color:red;">Rellena Cliente</p>
        @enderror
        <button type="submit" name="crearC">Crear Cita</button>
    </form>
    @if (session('mensaje'))
    <p style="color:red;">{{session('mensaje')}}</p>
    @endif
    <h2>Citas</h2>
    <table border="1" width="50%">
        <tr>
            <td>Id</td>
            <td>Fecha</td>
            <td>Hora</td>
            <td>Cliente</td>
            <td>Precio</td>
            <td>Acciones</td>
        </tr>
        @foreach ($citas as $c)
        <tr>
            <td>{{$c->id}}</td>
            <td>{{$c->fecha}}</td>
            <td>{{$c->hora}}</td>
            <td>{{$c->cliente}}</td>
            <td>{{$c->total}}</td>
            <td>
                <form action="{{route('cargarDetalle',$c->id)}}" method="get">
                    @csrf
                    <button type="submit" name="detalleC">Detalle</button>
                </form>
                <form action="{{route('borrarC',$c->id)}}"  method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" name="borrarC">Borrar</button>
                </form>
                
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>