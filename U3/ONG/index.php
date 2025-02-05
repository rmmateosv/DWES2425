<?php 
require_once 'controlador.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión ONG</title>
</head>

<body>
    <div>
        <h1 style='color:red;'><?php echo (isset($mensaje)?$mensaje:'')?></h1>
    </div>
    <?php if(!isset($_SESSION['centro'])){?>
    <!-- Formulario para seleccionar un centro -->
    <form action="" method="post">
        <label for="centro">Centro:</label>
        <?php $centros = $bd->obtenerCentros()?>
        <select name="centro" id="centro">
            <?php 
            foreach($centros as $c){
                echo '<option value="'.$c->getId().'">'.$c->getNombre().'</option>';
            }
            ?>
        </select>
        <button type="submit" name="seleccionarC">Seleccionar</button>
    </form>
    <?php }
    else{?>
    <!-- Datos del centro -->
    <form action="" method="post">
        <h3>
            <?php echo $_SESSION['centro']->getNombre().'-'.$_SESSION['centro']->getLocalidad() ?>
            <button type="submit" name="cambiarC">Cambiar Centro</button>
            <p>
            <?php 
            $info=$bd->obtenerInfo($_SESSION['centro']->getId());
            echo 'Beneficiarios:'.$info[0].'- Servicios:'.$info[1]; 
            ?>
            </p>
        </h3>
    </form>
    <!-- Formulario para asignar gestionar beneficiarios -->
    <form action="" method="post">
        <div>
            <label for="usuario">Beneficiario</label><br />
            <?php $bene = $bd->obtenerBeneficiariosCentro($_SESSION['centro']->getId())?>
            <select name="beneficiario" id="beneficiario">
            <?php 
                foreach($bene as $b){
                    echo '<option value="'.$b->getId().'">'.$b->getNombre().'-'.$b->getDni().'</option>';
                }
            ?>
            </select>
            <button type="submit" name="verSP">Ver Servicios Prestados</button>
            <button type="submit" name="borrarB">Borrar Beneficiario</button>
        </div>
        <p />
        <div>
            <label for="usuario">Servicio</label><br />
            <?php $servicios = $bd->obtenerServicios()?>
            <select name="servicio" id="servicio">
            <?php 
                foreach($servicios as $s){
                    echo '<option value="'.$s->getId().'">'.$s->getDescripcion().'</option>';
                }
            ?>
            </select>
        </div>
        <p />
        <div>
            <button type="submit" name="asignarS">Asignar</button>
        </div>
    </form>
    <?php 
        if(isset($serviciosB)){
            echo '<table>';
            echo '<tr><td>id</td><td>descripcion</td><td>fecha</td><td>beneficiario</td><td>dni</td></tr>';
            foreach($serviciosB as $s){
                echo '<tr><td>'.$s->getId().
                '</td><td>'.$s->getServicio()->getDescripcion().
                '</td><td>'.$s->getFecha().
                '</td><td>'.$s->getBeneficiario()->getNombre().
                '</td><td>'.$s->getBeneficiario()->getDni().'</td></tr>';
            }
            echo '</table>';
        }

}?>
</body>

</html>