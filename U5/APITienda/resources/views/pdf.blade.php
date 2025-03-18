<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $titulo }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { color: blue; }
    </style>
</head>
<body>
    <h1>{{ $titulo }}</h1>
    <p>Nº de pedidos:{{ $numPed }}</p>
    <p>Nº de productos:{{ $numProd }}</p>
    <p>Precio Medio de venta:{{ $pvpMedio }}</p>

    <table>
        <tr>
            <td>Producto</td>
            <td>Cantidad vendida</td>
            <td>Producto</td>
            <td>Cantidad vendida</td>
        </tr>
        <h2>Cantidad vendida por producto</h2>
        @foreach ($e1 as $e)
           <tr>
                <td>{{$e->producto->nombre}}</td>
                <td>{{$e->cantidad}}</td>
                <td>{{$e['producto_id']}}</td>
                <td>{{$e['cantidad']}}</td>
           </tr>
        @endforeach
        <h2>Total vendido por producto</h2>
        @foreach ($e2 as $e)
           <tr>
                <td>{{$e->producto}}</td>
                <td>{{$e->total}}</td>
           </tr>
        @endforeach
    </table>
</body>
</html>