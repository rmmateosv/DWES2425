<?php
require_once 'Ticket.php';
require_once 'AccesoDatos.php';

//Creamos una instancia de acceso a los datos
$ad = new AccesoDatos('ventas.txt');
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
        $datosPRoducto = explode('-',$_POST['producto']);
        $t = new Ticket($datosPRoducto[0],$datosPRoducto[1],$_POST['cantidad']);

        //Introducir el ticket en la venta
        $ad->insertarProducto($t);
    }
     //Recuperar lo que hay en el fichero y pintarlo en una tabla
     echo '<h3>Productos</h3>';
     echo '<table>';
     echo '<tr><th>Producto</th><th>Precio U</th><th>Cantidad</th><th>Total</th></tr>';
     //Creamos un array y lo rellenamos con todos los productos del fichero
     //El array va a contener objetos ticket
     $productos = $ad->obtenerProductos();
     foreach($productos as $p){
        echo '<tr>';
        echo '<td>'.$p->getProducto().'</td>';
        echo '<td>'.$p->getPrecioU().'</td>';
        echo '<td>'.$p->getCantidad().'</td>';
        echo '<td>'.$p->getTotal().'</td>';
        echo '</tr>';
     }
     echo '</table>';
    ?>
</body>
</html>