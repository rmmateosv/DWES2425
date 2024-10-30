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
if(isset($_POST['pCrear']) and $_SESSION['usuario']->getTipo()=='A'){
    //TEnemos que crear un préstamo
    //Usamos la función de la bd comprobarSiPrestar(pSocio int, pLibro int)
    //para ver si se puede hacer el préstamo
    $resultado = $bd->comprobar($_POST['socio'],$_POST['libro']);
    if($resultado=='ok'){
        //Hacer el préstamo
        $numero = $bd->crearPrestamo($_POST['socio'],$_POST['libro']);
        if($numero>0) {
            $mensaje='Préstamo nº '.$numero.' registrado';
        }
        else{
            $error = 'Se ha producido un error al crear el préstamo';
        }
    }
    else{
        $error = $resultado;
    }
}
if(isset($_POST['pDevolver']) and $_SESSION['usuario']->getTipo()=='A'){
    //Obtener el préstamos
    $p=$bd->obtenerPrestamo($_POST['pDevolver']);
    if($p!=null){
        //Chequear si hay que sancionar al socio
        $sancion=false;
        if(strtotime($p->getFechaD())<strtotime(date('Y-m-d'))){
            $sancion = true;
        }
        if($bd->devolverPrestamo($p,$sancion)){
            $mensaje='Préstamo devuelto';
            if($sancion){
                $mensaje.=' Se ha sancionado al socio';
            }
        }
        else{
            $error='Error, al devolver el préstamo';
        }
    }
    else{
        $error='Préstamo no existe';
    }
}
if(isset($_POST['lCrear']) and $_SESSION['usuario']->getTipo()=='A'){
    if(empty($_POST['titulo']) or empty($_POST['autor']) or empty($_POST['ejemplares'])){
        $error='Error, rellena los datos del libros';
    }
    else{
        $l = new Libro(0,$_POST['titulo'],$_POST['ejemplares'],$_POST['autor']);
        $numero = $bd->crearLibro($l);
        if($numero>0) {
            $mensaje='Libros nº '.$numero.' creado';
        }
        else{
            $error = 'Se ha producido un error al crear el libro';
        }
        
    }
}
if(isset($_POST['sCrear']) and $_SESSION['usuario']->getTipo()=='A'){
    if(!isset($_POST['dni']) or !isset($_POST['tipo'])){
        $error='Error, rellena dni y tipo';
    }
    else{
        //Comprobar si ya hay un usuario con ese dni
        $us = $bd->obtenerUsuarioDni($_POST['dni']);
        if($us==null){
            //Puedo crear el nuevo usuario
            if($_POST['tipo']=='A'){

            }
            elseif($_POST['tipo']=='S'){
               $_SESSION['crearSocio']=true;
            }
        }
        else{
            $error='Error, ya existe un usuario con ese DNI';
        }
    }
}
if(isset($_POST['sCrearSocio']) and $_SESSION['usuario']->getTipo()=='A'){
    //Crear Socio
    //Desctivamos los datos del socio en el formulario
    unset($_SESSION['crearSocio']);
}

?>