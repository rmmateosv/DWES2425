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
        <input type="submit" value="Crear Nota" name="crear">
    </form>
    <?php
    if(isset($_POST['crear'])){
        if(empty($_POST['asig']) or empty($_POST['fecha']) or empty($_POST['desc']) or empty($_POST['tipo']) or empty($_POST['nota'])){
            echo '<h3 style="color:red;">Rellena todos los campos</h3>';
        }
        else{
            $n = new Nota($_POST['asig'],$_POST['fecha'],$_POST['tipo'],$_POST['desc'],$_POST['nota']);
            $modelo->crearNota($n);
        }
    }
    ?>
    <h2>Notas</h2>
    <table border="1">
        <tr>
            <th>Asignatura</th>
            <th>Fecha</th>
            <th>Tipo</th>
            <th>Descripción</th>
            <th>Nota</th>
        </tr>
    <?php
    $notas=$modelo->obtenerNotas();
    foreach($notas as $n){
        echo '<tr>';
        echo '<td>'.$n->getAsi().'</td>';
        echo '<td>'.date('d/m/Y',strtotime($n->getFecha())).'</td>';
        echo '<td>'.$n->getTipo().'</td>';
        echo '<td>'.$n->getDesc().'</td>';
        echo '<td>'.$n->getNota().'</td>';
        echo '</tr>';
    }
    ?>
    </table>
</body>
</html>