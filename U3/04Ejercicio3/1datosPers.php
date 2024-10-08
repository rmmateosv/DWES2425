<?php
$nombre=(isset($_COOKIE['nombre'])?$_COOKIE['nombre']:'');
$ape=(isset($_COOKIE['ape'])?$_COOKIE['ape']:'');
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
        <div>
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" placeholder="Nombre" 
            value="<?php echo $nombre?>"/>
        </div>
        <div>
            <label for="ape">Apellidos</label>
            <input type="text" id="ape" name="ape"  placeholder="Apellidos" 
            value="<?php echo $ape?>"/>
        </div>
        <input type="submit" value="Guardar y continuar" name="guardar1">
    </form>
</body>
</html>