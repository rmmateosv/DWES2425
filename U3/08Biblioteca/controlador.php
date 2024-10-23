<?php
require_once 'Modelo.php';
session_start();
//Si no hay sessión iniciada, redirigimos a login
if(!isset($_SESSION['usuario'])){
    header('location:login.php');
}

if(isset($_POST['cerrar'])){
    session_destroy();
    header('location:login.php');
}
//Creamos objeto de acceso a la BD
$bd = new Modelo();
if(isset($_POST['pCrear'])){
    //TEnemos que crear un préstamo
    //Usamos la función de la bd comprobarSiPrestar(pSocio int, pLibro int)
    //para ver si se puede hacer el préstamo
    $resultado = $bd->comprobar($_POST['socio'],$_POST['libro']);
    if($resultado=='ok'){
        //Hacer el préstamo
        $numero = $bd->crearPrestamo($_POST['socio'],$_POST['libro']);
        if($numero>0) {
            $mensaje='Préstamo nº '.$numero.'registrado';
        }
        else{
            $error = 'Se ha producido un error al crear el préstamo';
        }
    }
    else{
        $error = $resultado;
    }
}
?>