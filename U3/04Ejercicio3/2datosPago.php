<?php
function comprobarCheck($texto){
    //Devuelve checke si está guardada la cookie y si no, simpre para transferencia
    if(!isset($_COOKIE['tipo']) and $texto=='Transferencia'){
        return 'checked="checked"';
    }
    if(isset($_COOKIE['tipo']) and $_COOKIE['tipo']==$texto){
        return 'checked="checked"';
    }
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
    <form action="tratarCookies.php" method="post">
        <input type="radio" name="tipo" <?php echo comprobarCheck('Transferencia')?> value="Transferencia"/>Transferencia
        <input type="radio" name="tipo" <?php echo comprobarCheck('Contrareembolso')?> value="Contrareembolso"/>Contrareembolso
        <input type="submit" value="Guardar y continuar" name="guardar2"/>
    </form>
</body>
</html>