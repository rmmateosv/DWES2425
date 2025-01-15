<?php 
require_once 'Usuario.php';
require_once 'Cliente.php';
require_once 'AD.php';

?>
<!doctype html>
<html>
      <head>
        <meta charset="utf-8">        
        <title>Recuoeración 22_23</title>
       </head>
     <body>
     		<?php      		
     		$bd = new AD();
     		if($bd->getConexion()==null){
     		    $mensaje = 'Error, no hay conexión con la base de datos mensajes';
     		}
     		else{
     		    if(isset($_POST['acceder'])){     		        
    	            //Obtener los datos del usuario logueado
     		        $u = $bd->obtenerUsuario($_POST['usuario'],$_POST['ps']);
     		        if($u != null){
     		            session_start();
     		            $_SESSION['usuario']=$u;
        	            if($u->getTipo()=='A'){
        	                header("location:crearCliente.php");
        	            }
        	            elseif($u->getTipo()=='C'){
        	                $bd = new AD();
        	                if($bd->getConexion()==null){
        	                    $mensaje= 'Error, no hay conexión con la base de datos mensajes';
        	                }else{
        	                    $c = $bd->obtenerCliente($u->getUsuario());
        	                    if($c->getBaja()){
        	                        $mensaje= 'Error, el usuario está dado de baja';
        	                    }
        	                    else{
        	                       header("location:misActividades.php");
        	                    }
        	                }
         		               
        	            }
     		        }
    	            else{
    	                $mensaje = 'Error, datos incorrectos';
    	            }
     		        
     		        
     		    }
     		}
     		?>   
 			<div> 
                <h1 style='color:red;'><?php if(isset($mensaje)){echo $mensaje;}?></h1> 
            </div>    
        	<form action="login.php" method="post">              	
            		<h1>SuperGim</h1>    
            		<div> 
                		<label for="usuario">Usuario</label><br/>           		
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