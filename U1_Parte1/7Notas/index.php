<?php
require_once 'Modelo.php';
$modelo = new Modelo();
//Cargar asignaturas en un array
$asigs = $modelo->obtenerAsignaturas();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Mis Notas de Exámenes y tareas 2º DAW</h1>
    <form action="" method="post">
        <div>
            <label for="asig">Asignatura</label><br/>
            <select name="asig" id="asig">
            <!-- HAcer un option para cada asignatura -->   
             <?php 
             foreach($asigs as $a){
                echo '<option>'.$a.'</option>';
             }
             ?>
            </select>
        </div>
        <div>
            <label for="fecha">Fecha</label><br/>
            <input type="date" name="fecha" id="fecha" value="<?php echo date('Y-m-d');?>"/>
        </div>
        <div>
            <label for="desc">Descripción</label><br/>
            <input type="text" name="desc" id="desc" placeholder="Examen tema 1"/>
        </div>
        <div>
            <label>Tipo</label><br/>
            <input type="radio" name="tipo" id="ex" value="Examen" checked="checked"/>
            <label for="ex">Examen</label>
            <input type="radio" name="tipo" id="ta" value="Tarea"/>
            <label for="ta">Tarea</label>
        </div>
        <div>
            <label for="nota">Nota</label><br/>
            <input type="number" name="nota" id="nota" placeholder="Nota"/>
        </div>
        <input type="submit" value="Crear Nota">
    </form>
</body>
</html>