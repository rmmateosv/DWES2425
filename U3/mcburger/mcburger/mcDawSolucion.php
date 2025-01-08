<?php
require_once 'Modelo.php';
require_once 'ProductoEnCesta.php';
$bd = new Modelo();
if($bd->getConexion()==null){
    $mensaje = "Error, no hay bd";
}
session_start();
if(isset($_POST['selTienda'])){
    $tienda = $bd->obtenerTienda($_POST['tienda']);
    $_SESSION['tienda'] = $tienda;
}
if(isset($_POST['cambiar'])){
    session_destroy();
    header('location:mcDawSolucion.php');
}
if(isset($_SESSION['tienda'])){
    $tienda = $_SESSION['tienda'];
}
if(isset($_POST['agregar'])){
    if($_POST['cantidad']<=0){
        $mensaje = 'Error, cantidad no puede ser 0';
    }
    else{
        $p = $bd->obtenerProducto($_POST['producto']);
        if(isset($_SESSION['cesta'])){
            $cesta = $_SESSION['cesta'];
        }
        else{
            $cesta=array();
        }
        $pC = new ProductoEnCesta($p,$_POST['cantidad']);
        $cesta[]=$pC;
        $_SESSION['cesta']=$cesta;
    }
}
if(isset($_POST['crearPedido'])){
    if(isset( $_SESSION['cesta']))
        $cesta = $_SESSION['cesta'];
    if(!isset( $_SESSION['cesta']) or empty($cesta)){
        $mensaje = "Error, cesta vacía";
    }
    else{
        $numPed = $bd->crearPedido($_SESSION['tienda'],$cesta);
        if($numPed > 0){
            $datos=$bd->datosPedido($numPed);
            $mensaje = "Pedido ".$numPed." generado. El nº de productos es ".$datos[1]." y el importe total del pedido es ".$datos[2];
            unset($_SESSION['cesta']);
        }
        else{
            $mensaje = "Error al crear el pedido";
        }
    }
    
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <h1 style='color:red;'><?php echo isset($mensaje)?$mensaje:'';?></h1>
    </div>
    <form action="" method="post">
        <?php
        if(!isset($tienda)){
        ?>
        <div>
            <h1 style='color:blue;'>Tienda</h1>
            <label for="tienda">Tienda</label><br />
            <select name="tienda">
                <?php
                $tiendas = $bd->obtenerTiendas();
                foreach($tiendas as $t){
                    echo '<option value="'.$t->getCodigo().'">'.$t->getNombre().'</option>';
                }
                ?>
            </select>
            <button type="submit" name="selTienda">Seleccionar tienda</button>
        </div>
        <?php
        }
        else{
        ?>
        
        <div>
            <h1 style='color:blue;'>Añade productos a la cesta</h1>
            <h2 style='color:green;'>Datos Tienda: <?php echo $tienda->getNombre().'-'.$tienda->getTelefono();?> 
                <button type="submit" name="cambiar">Cambiar Tienda</button>
            </h2>
            <table>
                <tr>
                    <td><label for="producto">Producto</label><br /></td>
                    <td><label for="cantidad">Cantidad</label><br /></td>
                    <td>Añadir a la cesta</td>
                </tr>
                <tr>
                    <td>
                        <select id="producto" name="producto">
                        <?php
                            $productos = $bd->obtenerProductos();
                            foreach($productos as $p){
                                echo '<option value="'.$p->getCodigo().'">'.$p->getNombre().'-'.$p->getPrecio().'</option>';
                            }
                        ?>
                        </select>
                    </td>
                    <td><input id="cantidad" type="number" name="cantidad" value="1"/></td>
                    <td><button type="submit" name="agregar">+</button></td>
                </tr>
            </table>            
        </div>
        <div>
            <h1 style='color:blue;'>Contenido de la cesta</h1>
            <table  border="1" rules="all" width="25%">
                <tr>
                    <td><b>Producto</b></td>
                    <td><b>Cantidad</b></td>
                    <td><b>Precio</b></td>
                </tr>
                
                <?php  
                if(isset($_SESSION['cesta'])){
                    foreach($_SESSION['cesta'] as $pc){
                        echo '<tr>';
                        echo '<td>'.$pc->getProducto()->getNombre().'</td>';
                        echo '<td>'.$pc->getCantidad().'</td>';
                        echo '<td>'.$pc->getCantidad()*$pc->getProducto()->getPrecio().'</td>';
                        echo '</tr>';
                    }
                }
                ?>
            </table>   
            <button type="submit" name="crearPedido">Crear Pedido</button>         
        </div>
        <?php
        }
        ?>
    </form>
</body>
</html>