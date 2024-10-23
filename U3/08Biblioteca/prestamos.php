<?php
require_once 'controlador.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>
    <?php
    require_once 'menu.php';
    ?>
    <div class="container">
        <br />
        <div>
            <!-- ÁREA DE ERRORES -->
            <?php
            if (isset($mensaje)) {
                echo '<div class="alert alert-success" role="alert">' . $mensaje . '</div>';
            }
            if (isset($error)) {
                echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
            }
            ?>
        </div>
        <div>
            <!-- ÁREA DE INSERT (SÓLO ADMIN) -->
            <?php
            if ($_SESSION['usuario']->getTipo() == 'A') {
                //Obtenemos los socios
                $socios = $bd->obtenerSocios();
                //Obtenemos libros
                $libros = $bd->obtenerLibros();
            ?>
                <form action="" method="post" class="row g-3">
                    <div class="col-md-3">
                        <label for="socio" class="form-label">Socio</label>
                        <select class="form-select" name="socio" id="socio">
                            <?php
                            foreach ($socios as $s) {
                                echo '<option value="' . $s->getId() . '">'
                                    . $s->getNombre() . '-' . $s->getUs() . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="libro" class="form-label">Libro</label>
                        <select class="form-select"  name="libro" id="libro">
                            <?php
                            foreach ($libros as $l) {
                                echo '<option value="' . $l->getId() . '">'
                                    . $l->getTitulo() . '-' . $l->getEjemplares() . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                    <label class="form-label">Acción</label><br/>
                        <button class="btn btn-outline-secondary" type="submit" id="pCrear" name="pCrear">+</button>
                    </div>
                </form>
            <?php
            }
            ?>
        </div>
    </div>
</body>

</html>