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
            //Obtenemos libros
            $libros = $bd->obtenerLibros();
        ?>
        <form action="" method="post">
            <label for="socio">Socio</label>
            <select name="socio" id="socio">
                <?php 
                foreach($socios as $s){
                    echo '<option value="'.$s->getId().'">'
                        .$s->getNombre().'-'.$s->getUs().'</option>';
                }
                ?>
            </select>
            <label for="libro">Libro</label>
            <select name="libro" id="libro">
                <?php 
                foreach($libros as $l){
                    echo '<option value="'.$l->getId().'">'
                        .$l->getTitulo().'-'.$l->getEjemplares().'</option>';
                }
                ?>
            </select>
            <button type="submit" name="pCrear">Crear Préstamo</button>
        </form>
        <?php
        }
        ?>
    </div>
</body>
</html>