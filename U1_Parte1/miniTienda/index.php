<?php
require_once 'Ticket.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>MiniTienda</h1> 
    <form action="#" method="post">
        <div>
            <label for="producto">Selecciona Producto</label><br/>
            <select name="producto" id="producto">
                <option>Camiseta Roja - 10</option>
                <option>Pitillos - 23</option>
                <option>Bufanda - 12</option>
                <option>Blusa Estampada - 20</option>
            </select>
        </div>
        <div>
            <label for="cantidad">Cantidad</label>
            <input type="number" id="cantidad" name="cantidad"  value="1"/>
        </div>
        <input type="submit" name="enviar" value="Añadir"/>
    </form>
    <?php
    if(isset($_POST['enviar'])){
        //Crear un objeto de la clase Ticket
        $producto[],
        $t = new Ticket();
    }
    ?>
</body>
</html>