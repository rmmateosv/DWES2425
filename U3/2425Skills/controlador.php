<?php
require_once 'Modelo.php';
session_start();
$bd = new Modelo();
if ($bd->getConexion() == null) {
    $error = 'Error, no hay conexión con la BD';
}

$mod = $bd->obtenerModalidades();


if (isset($_POST['selModalidad'])) {
    if (!empty($_POST['modalidad'])) {
        $m = $bd->obtenerModalidad($_POST['modalidad']);
        if ($m != null) {
            $_SESSION['mod'] = $m;
        } else {
            $error = 'Error, no se puede obtener la modalida';
        }
    }
} elseif (isset($_POST['selAlumno'])) {
    if (!empty($_POST['alumno'])) {
        $a = $bd->obtenerAlumno($_POST['alumno']);
        if ($a != null and $a->getModalidad() == $_SESSION['mod']->getId()) {
            $_SESSION['alumno'] = $a;
        } else {
            $error = 'Error, no se puede seleccionar el alumna';
        }
    }
} elseif (isset($_POST['cambiarM'])) {
    session_destroy();
    header('location:skills.php');
} elseif (isset($_POST['cambiarA'])) {
    unset($_SESSION['alumno']);
    header('location:skills.php');
} elseif (isset($_POST['guardar'])) {
    $p = $bd->obtenerPrueba($_POST['prueba']);
    if ($_POST['puntos'] > $p->getPuntuacion()) {
        $error = 'Error, no puede superar la puntaución máxima';
    } else {
        $c = $bd->obtenerCorrecion($_POST['prueba'], $_SESSION['alumno']->getId());
        if ($c != null) {
            $error = 'Error, la prueba ya está corregia';
        } else {
            if ($bd->crearCorreccion($_POST['prueba'], $_SESSION['alumno']->getId(), $_POST['puntos'], $_POST['comentario'])) {
                $error = 'Califiación creada y puntuación del alumno actualizada';
                //Actualizamos en la sesión los datos del alumno ya que ha cambiado la puntuación
                $_SESSION['alumno'] = $bd->obtenerAlumno($_SESSION['alumno']->getId());
            } else {
                $error = 'Error, no se ha creado la calificación';
            }
        }
    }
} elseif (isset($_POST['finalizar'])) {
    if (!$_SESSION['alumno']->getFinalizado()) {
        //Chequear si se han corregido todas las pruebas del alumno
        $c = $bd->obtenerCalificaciones($_SESSION['alumno']->getId());
        $p = $bd->obtenerPruebasModalidad($_SESSION['mod']->getId());
        if (sizeof($c) == sizeof($p)) {
            if ($bd->finalizarCorreccion($_SESSION['alumno']->getId())) {
                $error = 'Correción finalizada';
                //Actualizamos en la sesión los datos del alumno ya que ha cambiado la puntuación
                $_SESSION['alumno'] = $bd->obtenerAlumno($_SESSION['alumno']->getId());
            }
        } else {
            $error = 'Error, no se han corregido todas las pruebas. Nº de pruebas de la modalidad:'.sizeof($p).' y nº de pruebas corregidas: '.sizeof($c);
        }
    } else {
        $error = 'Error, ya se ha finalizado la correción del alumno';
    }
}
