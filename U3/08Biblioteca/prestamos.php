<?php
require_once 'controlador.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    require_once 'menu.php';
    ?>
    <div>
        <!-- ÁREA DE ERRORES -->
        <?php
        if(isset($error)){
            echo $error;
        }
        ?>
    </div>
    <div>
         <!-- ÁREA DE INSERT (SÓLO ADMIN) -->
        <?php
        if($_SESSION['usuario']->getTipo()=='A'){
            //Obtenemos los socios
            $socios = $bd->obtenerSocios();
        ?>
        <form action="" method="post">
            <label for="socio">Socio</label>
            <select name="socio" id="socio">

            </select>
        </form>
        <?php
        }
        ?>
    </div>
</body>
</html>