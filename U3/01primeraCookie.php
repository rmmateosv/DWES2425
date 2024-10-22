<?php
    //Recuperar valor de la cookie si está
    if(isset($_COOKIE['miPrimeraC'])){
        $valorC = $_COOKIE['miPrimeraC'];
    }
    if(isset($_POST['guardar'])){
        //CREamos una cookie y le damos el valor del input
        if(!empty($_POST['valor'])){
            //Ponemos como fecha de caducidad un mes a partir de hoy
            setcookie('miPrimeraC',$_POST['valor'],time()+(60*60*24*30));
            //REcargar la página para actualizar $_COOKIE
            header('location:01primeraCookie.php');
        }
    }
    if(isset($_POST['borrar'])){
        //Borrar cookie. Ponerla como caducada
        setcookie('miPrimeraC','',time()-1);
        //REcargar la página para actualizar $_COOKIE
        header('location:01primeraCookie.php');
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
        <label>Valor de la cookie</label>    
        <input type="text" name="valor"
            value="<?php echo (isset($valorC)?$valorC:'')?>"
            placeholder="Valor que se almacena en la cookie miPrimeraC"/>
        <input type="submit" name="guardar" value="Guardar"/>
        <input type="submit" name="borrar" value="Borrar">
    </form>
</body>
</html>