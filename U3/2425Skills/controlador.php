<?php
require_once 'Modelo.php';
session_start();
$bd = new Modelo();
if ($bd->getConexion() == null) {
    $error = 'Error, no hay conexión con la BD';
}

$mod = $bd->obtenerModalidades();


if(isset($_POST['selModalidad'])){
    if(!empty($_POST['modalidad'])){
        $m = $bd->obtenerModalidad($_POST['modalidad']);
        if($m!=null){
            $_SESSION['mod']=$m;
        }
        else{
            $error = 'Error, no se puede obtener la modalida';
        }
    }
}

elseif(isset($_POST['selAlumno'])){
    if(!empty($_POST['alumno'])){
        $a = $bd->obtenerAlumno($_POST['alumno']);
        if($a!=null and $a->getModalidad()==$_SESSION['mod']->getId()){
            $_SESSION['alumno']=$a;
        }
        else{
            $error = 'Error, no se puede seleccionar el alumna';
        }
    }
}
elseif(isset($_POST['cambiarM'])){
    session_destroy();
    header('location:skills.php');
}
elseif(isset($_POST['cambiarA'])){
    unset($_SESSION['alumno']);
    header('location:skills.php');
}
elseif(isset($_POST['guardar'])){
    $p=$bd->obtenerPrueba($_POST['prueba']);
    if($_POST['puntos']>$p->getPuntuacion()){
        $error='Error, no puede superar la puntaución máxima';
    }
    $c=$bd->obtenerCorrecion($_POST['prueba'],$_SESSION['alumno']->getId());
    if($c!=null){
        $error='Error, la prueba ya está corregia';
    }
    else{
        if($bd->crearCorreccion($_POST['prueba'],$_SESSION['alumno']->getId(),$_POST['puntos'])){
            $error='Califiación creada y puntuación del alumno actualizada';
        }
        else{
            $error='Error, no se ha creado la calificación';
        }
    }
}
?>