<?php
require_once 'Modelo.php';
session_start();
$bd = new Modelo();

//ver si se a pulsado en acceder 
if (isset($_POST['acceder'])) {
    //Chequear si se ha rellenado usuario y contraseña
    if (empty($_POST['usuario']) || empty($_POST['ps'])) {
        $mensaje = 'Usuario y contraseña Obligatorios';
    } else {
        $us = $bd->obtenerUsuario($_POST['usuario'], $_POST['ps']);
        //Comprobar si el usuario existe y está activo
        if ($us != null and $us->getActivo() == true) {
            //guardar usuario en la sesion
            $_SESSION['usuario'] = $us;
            header('location:index.php');
        } else {
            $mensaje = 'Usuario y Contraseña incorrectos';
        }
    }
} elseif (isset($_POST['salir'])) {
    session_destroy();
    setcookie('color','',time()-1);
    header('location:index.php');
} elseif (isset($_POST['cambiarColor'])) {
    setcookie('color', $_POST['color']);
    header('location:index.php');
}
