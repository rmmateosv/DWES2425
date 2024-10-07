<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="#" method="post">
        <label for="filas">Filas</label></br>
        <input type="number" id="filas" name="filas"></br>
        <label for="cols">Columnas</label></br>
        <input type="number" id="cols" name="cols"></br>
        <input type="submit" value="Crear" name="crear">
    </form>
    <?php 
        //Cuando pulsemos en crear, pintamos tabla
        if(isset($_POST['crear'])){
            //Pintar tabla
            if(!empty($_POST['filas'] and !empty($_POST['cols']))){
                $filas = $_POST['filas'];
                $cols = $_POST['cols'];
                echo '<table border="1">';
                $cont=1; //Contador que se pinta en cada celda
                for($i=0;$i<$filas;$i++){
                        echo "<tr>";
                        for($j=0;$j<$cols;$j++){
                            echo "<td>".$cont++."</td>";
                        }
                        echo "</tr>";
                }
                echo '</table>';


            }
            else{
                echo '<h3 style="color:red">Rellena filas y columnas</h3>';
            }
        }
    ?>
</body>
</html>