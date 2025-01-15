<?php
require_once 'Modelo.php';
session_start();

$bd = new Modelo();

if (isset($_POST['acceder'])) {
    if (empty($_POST['usuario']) or empty($_POST['ps'])) {
        $mensaje = 'Error, rellena usuario y contraseña';
    } else {
        $u = $bd->login($_POST['usuario'], $_POST['ps']);
        if ($u == null) {
            $mensaje = 'Error, datos incorrectos';
        } else {
            if (!$u->getActivo()) {
                $mensaje = 'Error, datos incorrectos';
            } else {
                $_SESSION['usuario'] = $u;
            }
        }
    }
} elseif (isset($_POST['salir'])) {
    session_destroy();
    header('location:index.php');
} elseif (isset($_POST['cambiarColor'])) {
    setcookie('colorR', $_POST['color']);
    header('location:index.php');
} elseif (isset($_POST['reservar'])) {
    if (empty($_POST) or empty($_POST['fecha']) or empty($_POST['hora'])) {
        $mensaje = 'Rellena todos los datos';
    } else {
        if ($bd->chequearReservar($_POST['recurso'], $_POST['fecha'], $_POST['hora'])) {
            if ($bd->reservar($_POST['recurso'], $_SESSION['usuario']->getIdRayuela(), $_POST['fecha'], $_POST['hora'])) {
                $mensaje = 'Reserva realizada';
                $_SESSION['usuario']=$bd->obtenerUsuario($_SESSION['usuario']->getIdRayuela());
            } else {
                $mensaje = 'Error, no se ha realizado la reserva';
            }
        } else {
            $mensaje = 'Error, recurso ya está asignado';
        }
    }
} elseif (isset($_POST['anular'])) {
    if (empty($_POST) or empty($_POST['fecha']) or empty($_POST['hora'])) {
        $mensaje = 'Rellena todos los datos';
    } else {
        if ($bd->anularReserva($_POST['recurso'], $_SESSION['usuario']->getIdRayuela(), $_POST['fecha'], $_POST['hora'])) {
            $mensaje = 'Reserva anulada';
            $_SESSION['usuario']=$bd->obtenerUsuario($_SESSION['usuario']->getIdRayuela());
        } else {
            $mensaje = 'Error, no se ha anulado la reserva';
        }
    }
}
