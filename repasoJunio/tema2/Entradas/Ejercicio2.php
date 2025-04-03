<?php
require_once "Modelo.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="post">
        <fieldset>
            <legend>Ventas de Entradas</legend>
            <label for="nombre">Nombre Completo</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo (!empty($_POST['nombre']) ? $_POST['nombre'] : '')?>"
            <br/>

            <label>Tipo Entrada:</label><br/>
            <input type="radio" name="tipoEntrada" id="tipoGeneral" checked="checked" value="General"/>
            <label for="tipoGeneral">General</label>

            <input type="radio" name="tipoEntrada" id="tipoMayor" value="Mayor 60"<?php 
                echo (isset($_POST['tipoEntrada']) && $_POST['tipoEntrada'] =='Mayor 60' ?'checked="checked"' :'');
            ?>/>
            <label for="tipoMayor">Mayor de 60</label>

            <input type="radio" name="tipoEntrada" id="tipoMenor" value="Menor 6" <?php 
                echo (isset($_POST['tipoEntrada']) && $_POST['tipoEntrada'] =='Menor 6' ?'checked="checked"' :'');
            ?>/>
            <label for="tipoMenor">Menor de 6 años</label>
            <br/>

            <label for="espectaculo">Espectaculo</label>
            <select name="espectaculo" id="espectaculo">
                <option <?php echo (isset($_POST['espectaculo']) && $_POST['espectaculo']=='Concierto' ? 'selected="selected"':'')?>>Concierto</option>
                <option <?php echo (isset($_POST['espectaculo']) && $_POST['espectaculo']=='Magia' ? 'selected="selected"':'')?>>Magia</option>
                <option <?php echo (isset($_POST['espectaculo']) && $_POST['espectaculo']=='Teatro' ? 'selected="selected"':'')?>>Teatro</option>
            </select>
            <br/>

            <label for="fechaEvento">Fecha del evento</label>
            <input type="date" name="fechaEvento" id="fechaEvento" value="<?php echo(!empty($_POST['fechaEvento'])? $_POST['fechaEvento']:date('Y-m-d'))?>">
            <br/>

            <label for="numEntradas">Número de entradas</label>
            <input type="number" name="numEntradas" id="numEntradas" value="<?php echo (!empty($_POST['numEntradas']) ? $_POST['numEntradas'] : '1')?>">
            <br/>

            <label for="descuento">Descuentos</label><br/>
            <select name="descuento[]" id="descuento" multiple="multiple">
                <option <?php echo(isset($_POST['descuento']) && in_array('familia numerosa',$_POST['descuento'])? 'selected="selected"':'')?>>familia numerosa</option>
                <option <?php echo(isset($_POST['descuento']) && in_array('abonado',$_POST['descuento'])? 'selected="selected"':'')?>>abonado</option>
                <option <?php echo(isset($_POST['descuento']) && in_array('Dia del espectador',$_POST['descuento'])? 'selected="selected"':'')?>>Dia del espectador</option>
            </select>
            <br/>

            <button type="submit" name="comprar" id="comprar">Comprar</button>
        </fieldset>
    </form>
</body>

<?php
if(isset($_POST['comprar'])){
    if(empty($_POST['nombre']) || !isset($_POST['tipoEntrada']) || !isset($_POST ['espectaculo']) || !isset($_POST['fechaEvento']) || !isset($_POST['numEntradas'])){
        echo "campo vacio";

    }else{

        if($_POST['numEntradas']<1 || ($_POST['numEntradas']>4)){
            echo "Tiene que ser entre 1 y 4";

        }else{
            if($_POST['tipoEntrada']=='Mayor 60' && isset($_POST['descuento']) && in_array('familia numerosa',$_POST['descuento'])) {
                echo "Mayor de 60 no es compatible con el descuento de familia numerosa";
            }else{

                $total=0;

                if($_POST['tipoEntrada']=='General'){
                    $total=10*($_POST['numEntradas']);
                }elseif($_POST['tipoEntrada']=='Mayor 60'){
                    $total=8*($_POST['numEntradas']);
                }else{
                    $total=5*($_POST['numEntradas']);
                }

                if(isset($_POST['descuento'])){
                    if(in_array('familia numerosa', $_POST['descuento'])){
                        $total=$total*0.95;
                    }
                    if(in_array('abonado', $_POST['descuento'])){
                        $total=$total*0.90;
                    }
                    if(in_array('Dia del espectador', $_POST['descuento'])){
                        $total=$total*0.98;
                    }
                }
                ?>

                <table border=1>
                    <tr>
                        <th colspan="2">TICKET DE COMPRA</th>
                    </tr>
                    <tr>
                        <td>Nombre</td>
                        <td><?php echo $_POST['nombre'] ?></td>
                    </tr>
                    <tr>
                        <td>Tipo de entrada</td>
                        <td><?php echo $_POST['tipoEntrada']?></td>
                    </tr>
                    <tr>
                        <td>Nº de entradas</td>
                        <td><?php echo $_POST['numEntradas']?></td>
                    </tr>
                    <tr>
                        <td>Descuentos</td>
                        <td><?php echo (isset($_POST['descuento']) ?  implode('/',$_POST['descuento']) : 'Ninguno' )?></td>
                    </tr>

                    <tr>
                        <td>Total a pagar</td>
                        <td><?php echo $total?></td>
                    </tr>

                    
                </table>

            <?php

                //crear el objeto entrada
                $e=new Entrada($_POST['nombre'],$_POST['tipoEntrada'], $_POST['fechaEvento'],
                                $_POST['numEntradas'],
                                (isset($_POST['descuento']) ? implode('/',$_POST['descuento']) : '') ,$total);
                $f=new Modelo();

                if($f->insertar($e)){
                    echo 'Entrada guardada';
                }

            }
        }
    }
}

?>

</html>