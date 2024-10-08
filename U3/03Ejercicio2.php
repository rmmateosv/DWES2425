<?php

if (isset($_POST['cambiar'])) {
  setcookie('colorFondo', $_POST['colorFondo'], time() + 60 * 60 * 24);
  setcookie('colorTexto', $_POST['colorTexto'], time() + 60 * 60 * 24);
  header('location:03Ejercicio2.php');
}

if (isset($_POST['resetear'])) {
  setcookie('colorFondo', '', time() - 1);
  setcookie('colorTexto', '', time() - 1);
  header('location:03Ejercicio2.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mantener Color - Cookies</title>
</head>

<body style="background-color: <?php echo (isset($_COOKIE['colorFondo']) ? $_COOKIE['colorFondo'] : 'white') ?>; color: <?php echo (isset($_COOKIE['colorTexto']) ? $_COOKIE['colorTexto'] : 'black') ?>">
  <form action="" method="post">
    <label>Color de fondo</label><br>
    <input type="color" name="colorFondo" id="colorFondo" 
      value="<?php echo (isset($_COOKIE['colorFondo']) ? $_COOKIE['colorFondo'] : '#FFFFFF')?>" />
    <br><br>
    <label>Color de texto</label><br>
    <input type="color" name="colorTexto" id="colorTexto" 
      value ="<?php echo (isset($_COOKIE['colorTexto']) ? $_COOKIE['colorTexto'] : 'black') ?>"/>
    <br><br>
    <input type="submit" value="Cambiar colores" name="cambiar"/>
    <input type="submit" value="Resetear colores" name="resetear"/>
  </form>
</body>

</html>