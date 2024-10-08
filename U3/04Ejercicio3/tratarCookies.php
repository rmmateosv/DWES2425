<?php
if(isset($_POST['guardar1'])){
    //Comprobar que se han rellenado datos
    if(empty($_POST['nombre']) or empty($_POST['ape'])){
        //Redirigimos a datos personales
        header('location:1datosPers.php');
    }
    else{
        //Creamos/Modificamos cookie
        setcookie('nombre',$_POST['nombre']);
        setcookie('ape',$_POST['ape']);
        header('location:2datosPago.php');
    }
}elseif(isset($_POST['guardar2'])){
    //Comprobar que se han rellenado datos
    if(empty($_POST['tipo'])){
        header('location:2datosPago.php');
    }
    else{
        setcookie('tipo',$_POST['tipo']);
        header('location:3mostrarDatos.php');
    }
}
?>