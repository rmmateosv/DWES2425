<?php
if (basename($_SERVER['PHP_SELF']) == 'menu.php') {
    header('location:prestamos.php');
}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'prestamos.php')?'active':''?>" aria-current="page" href="prestamos.php">Préstamos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'libros.php')?'active':''?>" href="libros.php">Libros</a>
                </li>
                <?php
                if ($_SESSION['usuario']->getTipo() == 'A') {
                ?>

                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'socios.php')?'active':''?>" href="socios.php">Usuarios</a>
                <?php
                }

                ?>


            </ul>
            <form action="" method="post" class="d-flex">
                <span class="navbar-text"><?php echo $_SESSION['usuario']->getId(); ?></span>
                <button class="btn btn-outline-secondary" type="submit" name="cerrar">Salir</button>
            </form>
        </div>
    </div>
</nav>