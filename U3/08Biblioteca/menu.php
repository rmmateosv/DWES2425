<?php
if (basename($_SERVER['PHP_SELF']) == 'menu.php') {
    header('location:prestamos.php');
}
?>

<a href="prestamos.php">Préstamos</a>
<a href="libros.php">Libros</a>
<?php
if ($_SESSION['usuario']->getTipo() == 'A') {
?>
    <a href="socios.php">Socios</a>
<?php
}
?>
<form action="" method="post">
    <span><?php echo $_SESSION['usuario']->getId(); ?></span>
    <button type="submit" name="cerrar">Salir</button>
</form>