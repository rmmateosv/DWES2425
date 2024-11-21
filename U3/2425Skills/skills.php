<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div>
        <h1 style='color:red;'>Mensajes</h1>
    </div>
    <form action="skills.php" method="post">
        <div>
            <h1 style='color:blue;'>Modalidad</h1>
            <label for="tienda">Modalidad</label><br />

            <select name="modalidad">

            </select>
            <button type="submit" name="selModalidad">Seleccionar Modalidad</button>
        </div>
        <div>
            <h1 style='color:blue;'>Alumno</h1>
            <label for="tienda">Alumno</label><br />
            <select name="alumno">

            </select>
            <button type="submit" name="selAlumno">Seleccionar Alumno</button>
        </div>
        <div>
            <h1 style='color:blue;'>Corrección</h1>
            <h2 style='color:green;'>Modalidad Seleccionada - Nombre Alumno - Nota:X (Provisional)
                <button type="submit" name="cambiarM">Cambiar Modalidad</button>
                <button type="submit" name="cambiarA">Cambiar Alumno</button>
            </h2>
            <table>
                <tr>
                    <td><label for="prueba">Prueba</label><br /></td>
                    <td><label for="puntos">Puntos</label><br /></td>
                    <td><label for="comentario">Comentario</label></td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <select id="prueba" name="prueba">

                        </select>
                    </td>
                    <td><input id="puntos" type="number" name="puntos" value="1" /></td>
                    <td><input id="comentario" type="text" name="comentario" placeholder="Comentario" /></td>
                    <td><button type="submit" name="guardar">Guardar</button></td>
                </tr>
            </table>
        </div>
        <div>
            <h1 style='color:blue;'>Calificaciones del alumno</h1>
            <table border="1" rules="all" width="50%">
                <tr>
                    <td><b>Prueba</b></td>
                    <td><b>Puntos Asignados</b></td>
                    <td><b>Puntos Obtenidos</b></td>
                    <td><b>Comentario</b></td>
                </tr>

            </table>
            <button type="submit" name="finalizar">Finalizar Corrección</button>
        </div>
    </form>
</body>

</html>