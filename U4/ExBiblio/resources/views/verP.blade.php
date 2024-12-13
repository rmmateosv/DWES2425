<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>PRÉSTAMOS</h1>
    <a href="{{route('rutaCrear')}}">+Nuevo</a>
    <table>
        <tr>
            <th>Id</th>
            <th>Fecha Préstamo</th>
            <th>Título Libro</th>
            <th>Cliente</th>
            <th>Fecha Devolución</th>
            <th>Acciones</th>
        </tr>
        @foreach ($prestamos as $p)
        <tr>
            <th>{{$p->id}}</th>
            <th>{{date('d/m/Y',strtotime($p->fecha))}}</th>
            <th>{{$p->libro->titulo}}</th>
            <th>{{$p->nombreCliente}}</th>
            <th>{{$p->fechaDevolucion}}</th>
            <th><a href="{{route('rutaModificar',$p->id)}}">Modificar</a></th>
        </tr>
        @endforeach
    </table>
</body>
</html>