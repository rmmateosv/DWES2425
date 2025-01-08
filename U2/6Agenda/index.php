<?php
require_once 'Modelo.php';
$modelo = new Modelo('agenda.dat');
?>
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
        else{
            //Chequear si ya hay un contacto para el teléfono
            $persona = $modelo->obtenerContacto($_POST['telf']);
            //Persona tiene null si no hay contacto y un objeto contacto
            //con todos los datos si sí hay contacto
            if($persona==null){
                $id = $modelo->obtenerID();
                //El nombre del fichero será el el instante de tiempo
                // en el que se sube y el nombre original.
                //Se guardarán en la carpeta img
                $nombref='img/'.time().$_FILES['foto']['name'];
                $c=new Contacto($id,$_POST['nombre'],$_POST['telf'],
                $_POST['tipo'],$nombref);
                //Guardar el contacto en el fichero
                $modelo->crearContacto($c);
                //Guardar foto en el servidor
                $destino = $nombref;
                $origen = $_FILES['foto']['tmp_name'];
                move_uploaded_file($origen,$destino);
            }
            else{
                echo '<h3 style="color:red;">Error:Ya existe un contacto con ese tlf '
                .$persona->getNombre().'</h3>';
            }
        }
    }
    ?>
    <table border="1">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Teléfono</th>
        <th>Tipo</th>
        <th>Foto</th>
    </tr>
    <?php
    //Mostrar contactos de la agenda
    $contactos = $modelo->obtenerContactos();
    foreach($contactos as $c){
        echo '<tr>';
        echo '<td>'.$c->getId().'</td>';
        echo '<td>'.$c->getNombre().'</td>';
        echo '<td>'.$c->getTelefono().'</td>';
        echo '<td>'.$c->getTipo().'</td>';
        echo '<td><img src="'.$c->getFoto().'" width="20px"/></td>';
        echo '</tr>';
    }
    ?>
    </table>
</body>
</html>