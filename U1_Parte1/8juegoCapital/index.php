<?php
require_once 'Modelo.php';
$modelo = new Modelo();
$preguntasFichero = $modelo->obtenerPreguntas();

if (!isset($_POST['validar']) or isset($_POST['pasar'])) {
    //Si se carga la página o se pulsa en pasar generamos una pregunta aleatoria
    $num = rand(0, sizeof($preguntasFichero)-1);
    $pregunta = $preguntasFichero[$num];
} else {
    //Si se ha pulsado en validar hay que mostrar si se ha acertado o no

    //Comprobar que se ha rellenado la respuesta
    if (!empty($_POST['respuesta'])) {
        //Variable para recordar el input de la respuesta
        $respuestaUS=$_POST['respuesta'];

        //Recuperamos la pregunta que se ha contestado a partir del id de la
        //pregunta que está como value en el botón validar
        foreach ($preguntasFichero as $p) {
            if ($p->getId() == $_POST['validar']) {
                //Creamos dos variables con la pregunta y la respuesta dada por el usuario para
                //recordar los datos
                $pregunta=$p;
               
                //Comprobar si las repuestas son iguales. Comprobamos siempre en minúsculas
                if (strtolower($p->getCapital()) == strtolower($respuestaUS)) {
                    $mensaje='<h3 style="color:green;">Correcto</h3>';
                }
                else{
                    $mensaje='<h3 style="color:red;">Incorrecto</h3>';
                }
                break; //No seguimos comprobando
            }
        }
    }
    else{
        $mensaje='<h3 style="color:red;">Rellena respuesta</h3>';
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
    <form action="" method="post" enctype="multipart/form-data">
        <div>
            <h2>¿Cuál es la capital de <?php echo $pregunta->getPais()?>?</h2>
            <input type="text" id="respuesta" name="respuesta" placeholder="Introduce capital" value="<?php echo (isset($respuestaUS)?$respuestaUS:'')?>"/>
        </div>
        <div>
            <?php echo (isset($mensaje)?$mensaje:'')?>
        </div>
        <button type="submit" value="<?php echo $pregunta->getId()?>" name="validar">Validar</button>
        <button type="submit" name="pasar">Pasar</button>
    </form>
</body>

</html>