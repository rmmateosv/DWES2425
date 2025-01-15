<?php
require_once 'controlador.php';

function seleccionado($id)
{
    if (isset($_POST['recurso']) and $_POST['recurso'] == $id) {
        return 'selected="selected"';
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reservas IES Augustóbriga</title>
</head>

<body>
    <h1>Reservas IES Augustóbriga</h1>

    <?php if (!isset($_SESSION['usuario'])) { ?>
        <!-- Sección de Login -->
        <section>
            <h2>Login</h2>
            <form action="" method="POST">
                <label for="usuario">Usuario</label><br />
                <input type="text" name="usuario" /><br />
                <label for="ps">Contraseña</label><br />
                <input type="password" name="ps"><br /><br />
                <button type="submit" name="acceder">Acceder</button>
            </form>
        </section>
    <?php } ?>


    <!-- Sección de Mensajes -->
    <section>
        <?php if (isset($mensaje)) {
            echo '<h3 style="color:red">' . $mensaje . '</h3>';
        } ?>
    </section>

    <!-- Información de usuario logueado -->
    <?php if (isset($_SESSION['usuario'])) { ?>
        <form method="post">
            <section>
                <table width="100%">
                    <tr>
                        <td>
                            <h3 style="color:blue">Id Rayuela</h3><?php echo $_SESSION['usuario']->getIdRayuela() ?>
                        </td>
                        <td>
                            <h3 style="color:blue">Nombre</h3><?php echo $_SESSION['usuario']->getNombre() ?>
                        </td>
                        <td>
                            <h3 style="color:blue">Número de Reservas</h3><?php echo $_SESSION['usuario']->getNumReservas() ?>
                        </td>
                        <td>
                            <h3 style="color:blue">Color Reservas</h3>

                            <input type="color" name="color" value="<?php echo (isset($_COOKIE['colorR']) ? $_COOKIE['colorR'] : '#FF0000') ?>" />
                            <input type="submit" name="cambiarColor" value="cambiar" />

                        </td>
                        <td>
                            <input type="submit" name="salir" value="Salir" />
                        </td>
                    </tr>
                </table>
            </section>



            <!-- Información del recurso seleccionado -->
            <section>
                <h3  style="color:blue">Selecciona Recurso</h3>
                <select name="recurso">
                    <?php
                    $recursos = $bd->obtenerRecursos();
                    foreach ($recursos as $r) {
                        echo '<option value="' . $r->getId() . '" ' . seleccionado($r->getId()) . '>' . $r->getNombre() . '</option>';
                    }
                    ?>
                </select>
                <input type="submit" name="verR" value="verReservas" />
                <table width="50%">
                    <tr>
                        <td>Id</td>
                        <td>Usuario</td>
                        <td>Recurso</td>
                        <td>Fecha</td>
                        <td>Hora</td>
                    </tr>
                    <?php
                    if (!empty($_POST['recurso'])) {
                        $reservas = $bd->obtenerReservasActivas($_POST['recurso']);
                        foreach ($reservas as $r) {
                            if ($r->getUsuario()->getIdRayuela() == $_SESSION['usuario']->getIdRayuela()) {
                                echo '<tr style="color:' . (isset($_COOKIE['colorR']) ? $_COOKIE['colorR'] : 'black') . '">';
                            } else {
                                echo '<tr>';
                            }
                            echo '<td>' . $r->getId() . '</td>';
                            echo '<td>' . $r->getUsuario()->getNombre() . '</td>';
                            echo '<td>' . $r->getRecurso()->getNombre() . '</td>';
                            echo '<td>' . $r->getFecha() . '</td>';
                            echo '<td>' . $r->getHora() . '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </table>
            </section>

            <!-- Crear/anular reserva -->
            <section>
                <h3  style="color:blue">Crear/Anular Reserva</h3>
                <label for="fecha">Fecha Reserva</label>
                <input type="date" name="fecha" id="fecha" value="<?php echo date('Y-m-d') ?>" />
                <label for="hora">Hora Reserva</label>
                <select name="hora" id="hora">
                    <option value="1">Primera</option>
                    <option value="2">Segunda</option>
                    <option value="3">Tercera</option>
                    <option value="4">Cuarta</option>
                    <option value="5">Quinta</option>
                    <option value="6">Sexta</option>
                </select>
                <button type="submit" name="reservar">Reservar</button>
                <button type="submit" name="anular">Anular</button>
            </section>
        </form>
    <?php
    }
    ?>
</body>

</html>