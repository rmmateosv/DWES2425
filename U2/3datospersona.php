<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="3datospersona.php" method="post">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" required value="<?php echo (!empty($_POST['nombre']) ? ($_POST['nombre']) : ''); ?>"><br>


        <label for="fec_nac">Fecha de nacimiento</label>
        <input type="date" name="fec_nac" id="fec_nac" required value="<?php echo date('Y-m-d', strtotime('2012-05-12')) ?>"><br>

        <label for="fec_prueba">Fecha de nacimiento</label>
        <input type="date" name="fec_prueba" id="fec_prueba" required value="<?php echo date('Y-m-d', 24*60*60+1) ?>"><br>

        <label for="edad">Edad</label>
        <input type="number" name="edad" id="edad" required value="<?php echo (!empty($_POST['edad']) ? ($_POST['edad']) : ''); ?>"><br>

        <label for="estatura">Estatura</label>
        <input type="number" step="0.1" name="estatura" id="estatura" value="<?php echo (!empty($_POST['estatura']) ? ($_POST['estatura']) : ''); ?>"><br>

        <label for="pass">Contraseña:</label>
        <input type="password" id="pass" name="pass">
        <button type="submit" name="enviar">Enviar</button>
    </form>

    <?php
        echo date('y-m-d');
        echo strtotime('2022-06-25');
            if(isset($_POST['enviar'])){
                if(empty($_POST['nombre']) || empty($_POST['fec_nac'] ) ||
                 empty($_POST['edad']) || empty($_POST['estatura'])){
                    echo "Rellena todos los campos";
                 }else{
                    $datos["nombre"] = $_POST['nombre'];
                    $datos["fec_nac"] = $_POST['fec_nac'];
                    $datos["edad"] = $_POST['edad'];
                    $datos["estatura"] = $_POST['estatura'];

                    
                   
                    
                  

                  // Pintar en tabla
                  echo "<br><br>";
                  echo "<table border = '1'>";
                  echo "<tr>";
                  echo "<th>Nombre</th>";
                  echo "<th>Fecha nac</th>";
                  echo "<th>Edad</th>";
                  echo "<th>Estatura</th>";
                  echo "</tr>";
                  echo "<tr>";
                  foreach($datos as $item){
                    echo "<td>".$item."</td>";
                
                  }
                  echo "</tr>";
                  echo "</table>";


                  $datos2= array("nombre" => $_POST['nombre'],
                  "fecha nac" => $_POST['fec_nac'],
                  "edad" => $_POST['edad'],
                  "estatura" => $_POST['estatura']
               );
                        echo "<h1>Array datos 2</h1>";
                        echo "<br>";
                        var_dump($datos2);
                       

                        $datos3 = ["nombre" => $_POST['nombre'],
                        "fecha nac" => $_POST['fec_nac'],
                        "edad" => $_POST['edad'],
                        "estatura" => $_POST['estatura']];

                       
                     
                        echo "<h1>Array datos 3</h1>";
                        echo "<br>";
                        var_dump($datos3);


                        
                        echo "<h1>Array datos 4</h1>";
                        echo "<br>";

                        $datos4[] = ["nombre"=> $_POST['nombre']];
                        $datos4[] = ["fec_nac"=> $_POST['fec_nac']];
                        $datos4[] = ["edad"=> $_POST['edad']];
                        $datos4[] = ["estatura"=> $_POST['estatura']];
                        var_dump($datos4);
                      
                }
            }
    ?>
</body>
</html>