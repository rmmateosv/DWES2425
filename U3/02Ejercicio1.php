<?php
$numAcceso=0;
$fechaUA='';

//Recuperamos valores de cookie si existen
if(isset($_COOKIE['numAccesos'])){
    $numAcceso=$_COOKIE['numAccesos'];
    $fechaUA=$_COOKIE['fechaUA'];  
}

//Cada vez que accedo a la página, incremento el nº de accesos y la fecha
//creando/modificando dos cookies
setcookie('numAccesos',$numAcceso+1);
setcookie('fechaUA',date('d/m/Y h:i:s'));

if(isset($_POST['borrar'])){
    setcookie('numAccesos','',time()-1);
    setcookie('fechaUA','',time()-1);
    //recargamos
    header('location:02Ejercicio1.php');
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
<form action="" method="post">
        <h3>Nº de accesos:<?php echo $numAcceso;?></h3>
        <h3>Fecha último acceso:<?php  echo $fechaUA;?></h3>
        <input type="submit" name="borrar" value="Borrar">
    </form>
</body>
</html>