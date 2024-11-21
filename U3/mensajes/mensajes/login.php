<?php
    require_once 'Modelo.php';
    $bd = new Modelo();
    if($bd->getConexion()==null){
        $mensaje = 'Error, no hay conexión con la bd';
    }
    else{
        if(isset($_POST['acceder'])){
            if(empty($_POST['usuario']) or empty($_POST['ps'])){
                //Mostrar error
                $mensaje = 'Error, rellena us y ps';
            }
            else{
                //Hacer login
                $retorno = $bd->login($_POST['usuario'],$_POST['ps']);
                if($retorno==0){
                    $mensaje='Error, no existe usuario';
                }
                elseif($retorno==1){
                    //Recueperar info del usuario
                    $usuario = $bd->obtenerEmpleado($_POST['usuario']);
                    //Guardar usuario en sesión
                    session_start();
                    $_SESSION['usuario']=$usuario;
                    //Redirigir a mensajes
                    header('location:mensajes.php');
                }
            }
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
 			<div> 
                <h1 style='color:red;'>
                <?php echo isset($mensaje)?$mensaje:'';?>
            </h1> 
            </div>    
        	<form action="login.php" method="post">              	
            		<h1>Login</h1>    
            		<div> 
                		<label for="usuario">Id de Empleado</label><br/>           		
                        <input type="text" id="usuario" name="usuario"/>  
                    </div>
                    <div> 
                        <label for="ps">Contraseña</label><br/>                           
                        <input type="password" id="ps"   name="ps"/>      
                    </div>                               
                    <br/><button type="submit" name="acceder">Acceder</button>                        
      		</form>           
	</body>
</html>