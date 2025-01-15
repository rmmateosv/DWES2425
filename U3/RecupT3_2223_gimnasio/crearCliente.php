<?php 
require_once 'AD.php';
require_once 'Usuario.php';
require_once 'Cliente.php';
require_once 'Actividad.php';
session_start();
if(!isset($_SESSION['usuario']) or isset($_POST['salir'])){
    session_unset();
    header("location:login.php"); 
}
else{
    $u=$_SESSION['usuario'];
    if($u->getTipo()!='A'){
        header("location:login.php");
    }
}
?>
<!doctype html>
<html>
      <head>
        <meta charset="utf-8">        
        <title>Examen 22_23</title>
       </head>
     <body>
     <?php 
     $bd = new AD();
     if($bd->getConexion()==null){
         $mensaje= 'Error, no hay conexión con la base de datos mensajes';
     }
     else{
         if(isset($_POST['crear'])){
             if(empty($_POST['usuario']) or empty($_POST['nombre']) or
                 empty($_POST['ape']) or empty($_POST['dni']) or empty($_POST['telef'])){
                 $mensaje="Error, no puede haber campos vacíos";
             }
             else{
                 if($bd->existeUsuario($_POST['usuario'],$_POST['dni'])){
                     $mensaje="Error, ya existe el usuario ".$_POST['usuario'];
                 }
                 else{
                     if($bd->crearCliente($_POST['usuario'],$_POST['nombre'],
                         $_POST['ape'],$_POST['dni'],$_POST['telef'])){
                         $mensaje="Cliente Creado";
                     }
                 }//else exsite usuario
             }// else no vacíos
         }//if crear
     }//else conexion
     ?>
		<form action="" method="post">    
     			<h1 style="color:blue;">CREAR CLIENTE</h1> 
        		<h2 style="color:blue;">
        			<?php echo 'Usuario:',$u->getUsuario();?>        			
 		        </h2> 
         		<div> 
                    <h3 style='color:red;'><?php if(isset($mensaje)){echo $mensaje;}?></h3> 
                </div>            	                                  	
                <br/><label>Usuario</label>  	
                <br/><input type="text" name="usuario"/>
                <br/><label>Nombre</label>  	
                <br/><input type="text" name="nombre"/>
            	<br/><label>Apellidos</label>  	
                <br/><input type="text" name="ape"/>
                <br/><label>DNI</label>  	
                <br/><input type="text" name="dni"/>
                <br/><label>Teléfono</label>  	
                <br/><input type="tel" name="telef"/>
            	<br/><input type="submit"  name="crear" value="Crear"/>                		
            	<input type="submit"  name="salir" value="Salir"/>                       
      		</form>       		
 			      
	</body>
</html>