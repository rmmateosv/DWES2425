<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reservas IES Augustóbriga</title>
</head>

<body>
    <h1>Reservas IES Augustóbriga</h1>
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

    <!-- Sección de Mensajes -->
    <section>
        <h3 style="color:red">Mensaje</h3>
    </section>

    <!-- Información de usuario logueado -->

    <form method="post">
        <section>
            <table width="100%">
                <tr>
                    <td>
                        <h3 style="color:blue">Id Rayuela</h3>
                    </td>
                    <td>
                        <h3 style="color:blue">Nombre</h3>
                    </td>
                    <td>
                        <h3 style="color:blue">Número de Reservas</h3>
                    </td>
                    <td>
                        <h3 style="color:blue">Color Reservas</h3>

                        <input type="color" name="color" />
                        <input type="submit" name="cambiarColor" value="cambiar" />
                    </td>
                    <td>
                        <input type="submit" name="salir" value="Salir" />
                    </td>
                </tr>
            </table>
        </section>
        <!-- Seleccionar Recurso -->
        <section>
            <h3 style="color:blue">Selecciona Recurso</h3>
            <select name="recurso">
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
            </table>
        </section>
        <!-- Crear/anular reserva -->
        <section>
            <h3 style="color:blue">Crear/Anular Reserva</h3>
            <label for="fecha">Fecha Reserva</label>
            <input type="date" name="fecha" id="fecha" />
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
</body>

</html>