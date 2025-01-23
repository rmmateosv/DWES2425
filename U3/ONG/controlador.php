<?php 
require_once 'Modelo.php';

session_start();

$bd=new Modelo();
if($bd->getCnx()==null){
    $mensaje='Error, no hay conexión';
}
if(isset($_POST['seleccionarC'])){
    //REcuperar el centro seleccionado
    $c = $bd->obtenerCentro($_POST['centro']);
    if($c!=null and $c->getActivo()){
        //Guardo el centro en la sesión
        $_SESSION['centro'] = $c;
        header('location:index.php');
    }
}
elseif(isset($_POST['cambiarC'])){
    session_destroy();
    header('location:index.php');
}
elseif(isset($_POST['verSP'])){
    $serviciosB=$bd->obtenerServiciosP($_POST['beneficiario']);
}
elseif(isset($_POST['borrarB'])){

    if($bd->borrarB($_POST['beneficiario'])){
        $mensaje='Beneficiario borrado';
    }
    else{
        $mensaje='Error al borrar el beneficiario';
    }
}
?>