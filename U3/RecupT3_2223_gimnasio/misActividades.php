<?php 
require_once 'AD.php';
require_once 'Usuario.php';
require_once 'Cliente.php';
require_once 'Actividad.php';


function seleccionar($id){
    if(isset($_POST['actividad'])){
        if($_POST['actividad']==$id){
            return 'selected=selected';
        }
    }
}
session_start();
if(!isset($_SESSION['usuario']) or isset($_POST['salir'])){
    session_unset();
    header("location:login.php"); 
}
else{
    $u=$_SESSION['usuario'];
    if($u->getTipo()!='C'){
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
     		    $cliente = $bd->obtenerCliente($u->getUsuario()); 
     		    if($cliente)
     		    //REcuperar de la sesión el empleado logueado     		    
     		    if(isset($_POST["contratar"])){
     		        if($bd->existeActividadContratada($cliente->getId(),$_POST["actividad"])){
     		            $mensaje="Error, ya tienes contrada la actividad";
     		        }
     		        else{
     		            if($bd->ContratarActividad($cliente->getId(),$_POST["actividad"])){
     		                $mensaje="Actividad contratada";
     		                    		                
     		            }
     		            else{
     		                $mensaje="Error al contratar la actividad";
     		            }
     		        }
     		    }
     		    if(isset($_POST["baja"])){
     		        if($bd->existeActividadContratada($cliente->getId(),$_POST["actividad"])){
     		            if($bd->BajaActividad($cliente->getId(),$_POST["actividad"])){
     		                $mensaje="Te has dado de baja de la actividad";
     		                  		                
     		            }
     		            else{
     		                $mensaje="Error al contratar la actividad";
     		            }
     		        }
     		        else{
     		            $mensaje="Error, no tienes contrada la actividad";
     		            
     		        }
     		    }
     		   
     		    $actividades = $bd->obtenerActividades();
     		    $contratadas = $bd->obtenerContratadas($cliente->getId());
     		    if(isset($_POST['actividad'])){
     		        $aSel = $bd->obtenerActividad($_POST['actividad']);
     		    }
     		    else{
     		        $aSel = $bd->obtenerPrimeraActividad();
     		    }
     		 }
     		    
     		?>
     		<form action="" method="post">    
     			<h1 style="color:blue;">INSCRIBITE EN LAS ACTIVIDADES QUE TE GUSTEN</h1> 
        		<h2 style="color:blue;">
        			<?php echo 'Cliente:',$cliente->getId()," - ", 
        			$cliente->getNombre(), " ",$cliente->getApellidos();?>        			
 		        </h2> 
         		<div> 
                    <h3 style='color:red;'><?php if(isset($mensaje)){echo $mensaje;}?></h3> 
                </div>            	                      
            	<label>Actividad</label>	
            	<select id="actividad" name="actividad" onchange="this.form.submit()">
                        <?php 
                        foreach($actividades as $a){                            
                            echo "<option value='".$a->getId()."'".seleccionar($a->getId()).">".$a->getNombre()."</option>";
                        }
                        ?>
                </select>
                <label>Coste Mensual</label>  	
                <input type="number" value="<?php echo $aSel->getCoste_mensual();?>" disabled="disabled"/>
            	<input type="submit"  name="contratar" value="Contratar"/>    
            	<input type="submit"  name="baja" value="Baja"/> 	
            	<input type="submit"  name="salir" value="Salir"/>                       
      		</form> 
      		<h3 style='color:blue;'>Actividades Contratadas</h3>           		
      		<hr/> 
      		<table width="100%">
      			<tr>
      				<th align="left">Id</th>
      				<th align="left">Nombre</th>
      				<th align="left">Coste Mensal</th>
      			</tr>
      			<?php
      			
      			foreach ($contratadas as $ac){
      			    echo "<tr><td>".$ac->getId()."</td>
      				<td>".$ac->getNombre()."</td>
      				<td>".$ac->getCoste_mensual()."€</td></tr>";
      			   
      			}
      			?>
      		</table>       	
    		<hr/> 
    		
     		
 			      
	</body>
</html>
