<?php
//Añadir un contador de aciertos y de fallos
//guardando estos datos en la sesión
//Consideramos que pasar se contabiliza como fallo
session_start();
require_once 'Modelo.php';


//Si se pulsa en salir se destruye la sesión
if(isset($_GET['salir']) ){
    //Elimina sesisón en servidor
    session_destroy();
    //Eliminar variables en servidor
    session_unset();
    header('location:index.php');
}
//Si no hay noombre no se puede jugar
if(!isset($_SESSION['nombre'])){
    header('location:inicio.php');
}


$modelo = new Modelo();
$preguntasFichero = $modelo->obtenerPreguntas();

if (!isset($_POST['validar']) or isset($_POST['pasar'])) {
    //Si se carga la página o se pulsa en pasar generamos una pregunta aleatoria
    $num = rand(0, sizeof($preguntasFichero) - 1);
    $pregunta = $preguntasFichero[$num];

    if(isset($_POST['pasar'])){
        //Incremetamos fallos
        if(isset($_SESSION['fallos'])){
            $_SESSION['fallos']++;
        } 
        else{
            $_SESSION['fallos']=1;
        }
    }
} else {
    //Si se ha pulsado en validar hay que mostrar si se ha acertado o no

    //Comprobar que se ha rellenado la respuesta
    if (!empty($_POST['respuesta'])) {
        //Variable para recordar el input de la respuesta
        $respuestaUS = $_POST['respuesta'];

        //Recuperamos la pregunta que se ha contestado a partir del id de la
        //pregunta que está como value en el botón validar
        foreach ($preguntasFichero as $p) {
            if ($p->getId() == $_POST['validar']) {
                //Creamos dos variables con la pregunta y la respuesta dada por el usuario para
                //recordar los datos
                $pregunta = $p;

                //Comprobar si las repuestas son iguales. Comprobamos siempre en minúsculas
                if (strtolower($p->getCapital()) == strtolower($respuestaUS)) {
                    $mensaje = '<h3 style="color:green;">Correcto</h3>';
                    //Incremetamos aciertos
                    if(isset($_SESSION['aciertos'])){
                        $_SESSION['aciertos']++;
                    } 
                    else{
                        $_SESSION['aciertos']=1;
                    }
                    //Recargamos página si acertamos para on pulsar en pasar
                    //header('location:index.php');
                } else {
                    $mensaje = '<h3 style="color:red;">Incorrecto</h3>';
                    //Incremetamos fallos
                    if(isset($_SESSION['fallos'])){
                        $_SESSION['fallos']++;
                    } 
                    else{
                        $_SESSION['fallos']=1;
                    }
                }
                break; //No seguimos comprobando
            }
        }
    } else {
        $mensaje = '<h3 style="color:red;">Rellena respuesta</h3>';
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
    <h1>JUEGO CAPITAL</h1>
    <h2><?php echo $_SESSION['nombre']?></h2>
    <a href="index.php?salir=1">Salir</a>
    <table>
        <tr>
            <td>
                <form action="" method="post" enctype="multipart/form-data">
                    <div>
                        <h2>¿Cuál es la capital de <?php echo $pregunta->getPais() ?>?</h2>
                        <input type="text" id="respuesta" name="respuesta" placeholder="Introduce capital" value="<?php echo (isset($respuestaUS) ? $respuestaUS : '') ?>" />
                    </div>
                    <div>
                        <?php echo (isset($mensaje) ? $mensaje : '') ?>
                    </div>
                    <button type="submit" value="<?php echo $pregunta->getId() ?>" name="validar">Validar</button>
                    <button type="submit" name="pasar">Pasar</button>
                </form>
            </td>
            <td style="padding-left: 20px;">
                <?php 
                    if(isset($_SESSION['aciertos'])){
                        $aciertos = $_SESSION['aciertos'];
                    }
                    else{
                        $aciertos=0;
                    }
                    if(isset($_SESSION['fallos'])){
                        $fallos = $_SESSION['fallos'];
                    }
                    else{
                        $fallos=0;
                    }
                ?>
                <h2 style="color:green">Aciertos:<?php echo $aciertos?></h2>
                <h2 style="color:red">Fallos:<?php echo $fallos ?></h2>
            </td>
        </tr>
    </table>

</body>

</html>