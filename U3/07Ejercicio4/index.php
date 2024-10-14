<?php
require_once 'Evento.php';

if (isset($_COOKIE['eventos'])) {
    //Recojo el valor de la cookie si lo tiene
    $eventos = unserialize($_COOKIE['eventos']);
    echo 'Array en cookie:'.var_dump(array_keys($eventos));
}
else{
    $eventos=array();
}
//Si se ha pulsado el botón añadir
if (isset($_POST['aniadir'])) {
    // Y todos los campos estan creados
    if (!empty($_POST['fecha']) and !empty($_POST['hora']) and !empty($_POST['asunto'])) {
        //Cambio el formato de la fecha
        $fecha = date('d/m/Y',strtotime($_POST['fecha']));
        //Creo el objeto evento
        $e = new Evento($fecha,$_POST['hora'],$_POST['asunto']);
        //Si el array eventos esta vacio introduzco en la primera posicion y si no en la última
        $eventos[] = $e;
        
    }
    else{
        $error='Rellena todos los campos';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de eventos</title>
    <style>
        td{
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>Calendario de Eventos</h1>
    <table>
        <tr>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Asunto</th>
        </tr>
        <?php
        //Declaro el foreach si eventos no esta vacio y pinto todos los eventos con su botón
        if (!empty($eventos)) {
            //Creo la variable i para darselo al value del boton y asi despues saber que posición debo borrar

            foreach ($eventos as $i=>$event) {
                
                echo "<tr><td>" . $event->getFecha() . "</td>";
                echo "<td>" . $event->getHora() . "</td>";
                echo "<td>" . $event->getAsunto() . "</td>";
                echo "<td><form action='#' method='post'>
                <button type='submit' value='".$i."' name='eliminar'>Eliminar</button>
                </form></td></tr>";

                
            }
        }
        ?>
        <tr>
            <form action="#" method="post">
                <td><input type="date" name="fecha" id="fecha"></td>
                <td><input type="time" name="hora" id="hora" placeholder="--:--"></td>
                <td><input type="text" name="asunto" id="asunto"></td>
                <td><input type="submit" name="aniadir" value="Añadir"></td>
            </form>
        </tr>
    </table>
    <?php
    if(isset($_GET['error'])){
        echo $_GET['error'];
    }
    //Si se ha pulsado algunos de los botones eliminar borro el valor del pulsado
    if (isset($_POST['eliminar'])) {
        unset($eventos[$_POST['eliminar']]);
        $eventos=array_values($eventos);
    }
    //Si se ha pulsado añadir o borrar actualiza la cookie con el valor de eventos y recarga la pagina
    if (isset($_POST['aniadir']) or isset($_POST['eliminar'])) {
        setcookie('eventos',serialize($eventos),time()+(60*60*24*30));
        if(isset($error)){
            header('location:index.php?error='.$error);
        }

        else{
            header('location:index.php');
        }
        
    }
    ?>
</body>

</html>