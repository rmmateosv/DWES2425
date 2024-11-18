<?php
require_once 'Modelo.php';

$m = new Modelo();

function rellenarSelect($valor,$defecto){
    if(isset($_POST['tipo'])){
        if($_POST['tipo']==$valor){
            echo 'selected="selected"';
        }
    }
    elseif($defecto){
        echo 'selected="selected"';
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
    <h1>Tintorería la Morala</h1>
    <form action="" method="post">
        <fieldset>
            <legend>Registrar Trabajo</legend>
            <div>
                <label for="fecha">Fecha Entrada</label><br />
                <input type="date" id="fecha" name="fecha" value="<?php 
                    echo (isset($_POST['fecha'])?$_POST['fecha']:date('Y-m-d')) ?>" />
            </div>
            <div>
                <label for="nombre">Cliente</label><br />
                <input type="text" id="nombre" name="nombre" placeholder="Nombre cliente" value="<?php 
                    echo (isset($_POST['nombre'])?$_POST['nombre']:'')
                ?>"/>
            </div>
            <div>
                <label for="tipo">Tipo</label><br />
                <select name="tipo_aux" id="tipo_aux">
                    
                    <option <?php 
                    echo (isset($_POST['tipo']) && $_POST['tipo']=='Fiesta'?'selected="selected"':'')
                    ?>>Fiesta</option>
                    <option <?php 
                    echo (isset($_POST['tipo']) && $_POST['tipo']=='Cuero'?'selected="selected"':'')
                    ?>>Cuero</option>
                    <option <?php 
                    echo (isset($_POST['tipo']) && $_POST['tipo']=='Hogar'?'selected="selected"':'')
                    ?>>Hogar</option>
                    <option <?php 
                    echo ((!isset($_POST['tipo'])) || (isset($_POST['tipo']) && $_POST['tipo']=='Textil')?'selected="selected"':'')
                    ?>>Textil</option>
                </select>
                <select name="tipo" id="tipo">
                    <option <?php rellenarSelect('Fiesta',false)?>>Fiesta</option>
                    <option <?php rellenarSelect('Cuero',false)?>>Cuero</option>
                    <option <?php rellenarSelect('Hogar',false)?>>Hogar</option>
                    <option <?php rellenarSelect('Textil',true)?>>Textil</option>
                </select>
            </div>
            <div>
                <label>Servicios</label><br />
                <input type="checkbox" id="limpieza" name="servicios[]" value="limpieza" />
                <label for="limpieza">Limpieza</label>
                <input type="checkbox" id="planchado" name="servicios[]" value="planchado" />
                <label for="planchado">Planchado</label>
                <input type="checkbox" id="desmanchado" name="servicios[]" value="desmanchado" />
                <label for="desmanchado">Desmanchado</label>
            </div>
            <div>
                <label for="importe">Importe</label><br />
                <input type="number" id="importe" name="importe" value="<?php 
                echo (isset($_POST['importe'])?$_POST['importe']:1)
                ?>" />
            </div>
            <div>
                <input type="submit" name="guardar" value="guardar"/>
        </div>
        </fieldset>
    </form>
    <?php
    
    if (isset($_POST['guardar'])) {
        if (empty($_POST['fecha']) or empty($_POST['nombre']) or empty($_POST['tipo']) or empty($_POST['importe'])) {
            echo 'Rellena fecha, nombre, tipo e importe';
            $error=true;
        }
        if(!isset($_POST['servicios']) or sizeof($_POST['servicios'])<1){
            echo 'Al menos debes marcar un servicio';
            $error=true;
        }
        //if(isset($_POST["tipo"]) and $_POST['tipo']=="Cuero" 
             //and isset($_POST['servicios']) and in_array('Planchado',$_POST['servicios'])){
        if(isset($_POST["tipo"]) and $_POST['tipo']=="Cuero" 
             and isset($_POST['servicios']) and in_array('planchado',$_POST['servicios'])){
            //foreach($_POST['servicios'] as $s){
              //  if($s=='Planchado'){
                    echo 'No puedes seleccionar Cuero y planchado';
                    $error=true;
                //    break;
                //}
            //}
        }
        if(isset($_POST['tipo']) and $_POST['tipo']=='Fiesta' 
            and isset($_POST['importe']) and $_POST['importe']<=50){
                echo 'El importe en prendas de fiesta debe ser > 50';
                $error=true;
        }

        if(!isset($error)){
            echo '<h2>Datos Correctos</h2>';
            echo '<h3>Prenda:'.$_POST['tipo'].'</h3>';
            echo '<h3>Servicio:'.implode('/',$_POST['servicios']).'</h3>';
            $t = new Trabajo($_POST['fecha'],$_POST['nombre']
                 ,$_POST['tipo'],implode('/',$_POST['servicios']),$_POST['importe']);
            if($m->guardarTrabajo($t)){
                echo 'Trabajo guardado';
            }
            else{
                echo 'Error, Trabajo no guardado';
            }
        }
    }
    ?>
    <table>
        <tr>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Tipo</th>
            <th>Servicios</th>
            <th>Importe</th>
        </tr>
    <?php
    $trabajos = $m->obtenerTrabajos();
    foreach($trabajos as $t){
        echo '<tr>';
        echo '<td>'.$t->getFecha().'</td>';
        echo '<td>'.$t->getCliente().'</td>';
        echo '<td>'.$t->getTipo().'</td>';
        echo '<td>'.$t->getServicios().'</td>';
        echo '<td>'.$t->getImporte().'</td>';
        echo '</tr>';
    }
    ?>
    </table>
</body>
</html>