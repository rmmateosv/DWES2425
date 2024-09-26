<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="#" method="post" enctype="multipart/form-data">
        <div>
            <label for="nombre">Nombre</label><br/>
            <input type="text" id="nombre" name="nombre" 
                value="<?php echo (isset($_POST['nombre'])?$_POST['nombre']:'')?>"/>
        </div>
        <div>
            <label for="telf">Teléfono</label><br/>
            <input type="text" id="telf" name="telf" pattern="[0-9]{9}"
                value="<?php echo (isset($_POST['telf'])?$_POST['telf']:'')?>"/>
        </div>
        <div>
            <label>Tipo</label><br/>
            <label for="amigo">Amigo</label>
            <input type="radio" id="amigo" name="tipo" value="Amigo" checked="checked"/>
            <label for="familia">Familia</label>
            <input type="radio" id="familia" name="tipo" value="Familia" 
                <?php echo ((isset($_POST['tipo']) and $_POST['tipo']=='Familia')?'checked="checked"':'')?>/>
            <label for="otros">Otros</label>
            <input type="radio" id="otros" name="tipo" value="Otros" 
            <?php echo ((isset($_POST['tipo']) and $_POST['tipo']=='Otros')?'checked="checked"':'')?>/>
        </div>
        <div>
            <label for="foto">Foto</label>
            <input type="file" id="foto" name="foto"/>
        </div>
        <input type="submit" value="Crear" name="crear">
    </form>
    <?php
    if(isset($_POST['crear'])){
        if(empty($_POST['nombre']) || empty($_POST['telf']) or empty($_FILES['foto']['name']) or empty($_POST['tipo'])){
            echo '<h3 style="color:red;">Error, hay campos vacíos</h3>';
        }
    }
    else{

    }
    ?>
</body>
</html>