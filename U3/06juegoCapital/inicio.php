<?php
if(isset($_POST['jugar'])){
    session_start();
    $_SESSION['nombre']=$_POST['nombre'];
    header('location:index.php');
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
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" required="required"/>

        <input type="submit" name="jugar" value="Jugar"/>
    </form>
</body>
</html>