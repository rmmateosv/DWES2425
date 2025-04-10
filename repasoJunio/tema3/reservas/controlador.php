<?php
require_once 'Modelo.php';
session_start();
$bd=new Modelo();

//ver si se a pulsado en acceder 
if (isset($_POST['acceder'])) {
    //Chequear si se ha rellenado usuario y contraseña
    if (empty($_POST['usuario']) || empty($_POST['ps'])) {
        $mensaje = 'Usuario y contraseña Obligatorios';
    }else{
       $us=$bd->obtenerUsuario($_POST['usuario'], $_POST['ps']);
       //Comprobar si el usuario existe
       if ($us != null) {
        //guardar usuario en la sesion
        $_SESSION['usuario']= $us;
        header('location:index.php'); 
       }
    }
}


?>