<?php
const MINOMBRE = 'Rosa';
//Chequear si se han escrito números
if(!empty($_GET['n1']) and !empty($_GET['n2'])){
    $n1=$_GET['n1'];
    $n2=$_GET['n2'];

    //Comprobar si se ha pulsado +
    if(isset($_GET['+'])){
        $operador = "+";
        $resultado = $n1+$n2;
    }
    elseif(isset($_GET['-'])){
        $operador = "-";
        $resultado = $n1-$n2;
    }
    elseif(isset($_GET['*'])){
        $operador = "*";
        $resultado = $n1*$n2;
    }
    elseif(isset($_GET['/'])){
        $operador = "/";
        $resultado = $n1/$n2;
    }

}
else{
    if(isset($_GET['n1']) or isset($_GET['n2']))
        $error = 'Error, rellena los números';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora</title>
</head>
<body>
    <h1>CALCULADORA DE <?php echo MINOMBRE?></h1>
    <!-- action: página que trata el formulario cuando se hace submit-->
    <form action="1calculadora.php"  metho="get">
        <label for="n1">Número1</label>
        <input type="number" name="n1" id="n1"><br/>
        <label for="n2">Número2</label>
        <input type="number" name="n2" id="n2"><br/>

        <button type="submit" name="+">+</button>
        <button type="submit" name="-">-</button>
        <button type="submit" name="*">*</button>
        <button type="submit" name="/">/</button>
    </form>
    <!-- Mostrar el resultado, si se ha calculado o el error-->
    <?php 
    if(isset($error)){
        echo "<h3 style='color:red;'>$error</h3>";
    }
    if(isset($resultado)){
        echo "<h3 style='color:red;'>El resultado de $n1 $operador $n2 = $resultado</h3>";
        echo '<h3 style="color:red;">El resultado de $n1 $operador $n2 = $resultado</h3>';
    }
    ?>
</body>
</html>