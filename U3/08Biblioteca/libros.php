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
            <?php
            if($_SESSION['usuario']->getTipo()=='A'){
            ?>
                <form action="" method="post" class="row g-3">
                    <div class="col-md-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Título"/>
                    </div>
                    <div class="col-md-3">
                        <label for="autor" class="form-label">Autor</label>
                        <input type="text" class="form-control" name="autor" id="autor"  placeholder="Autor"/>
                    </div>
                    <div class="col-md-3">
                        <label for="ejemplares" class="form-label">Ejemplares</label>
                        <input class="form-control" name="ejemplares" id="ejemplares" value="1" type="number"/>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Acción</label><br />
                        <button class="btn btn-outline-secondary" type="submit" id="lCrear" name="lCrear">+</button>
                    </div>
                </form>
            <?php
            }
            ?>
        </div>
        <div>
            <br />
            <!-- mostrar libros -->
            <form action="" method="post">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Ejemplares</th>
                            <?php if($_SESSION['usuario']->getTipo()=='A'){?>
                                <th>Acciones</th>
                            <?php }?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $libros=$bd->obtenerLibros();
                        foreach ($libros as $l) {
                            echo '<tr>';
                            echo '<td>' . $l->getId() . '</td>';
                            echo '<td>' . $l->getTitulo(). '</td>';
                            echo '<td>' . $l->getAutor() . '</td>';
                            echo '<td>' . $l->getEjemplares() . '</td>';
                            if($_SESSION['usuario']->getTipo()=='A'){
                                echo '<td>';
                                echo '<button class="btn btn-outline-secondary" type="submit" name="lModificar" 
                                    value="' . $l->getId() . '">Modificar</button>';
                                echo '<button class="btn btn-outline-secondary" type="submit" name="lBorrar" 
                                value="' . $l->getId() . '">Borrar</button>';
                                echo '</td>';
                            }
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</body>

</html>