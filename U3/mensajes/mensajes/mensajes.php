<?php
require_once 'Modelo.php';

$bd = new Modelo();
if($bd->getConexion()==null){
	$mensaje = 'Error, no hay conexión con la bd';
}
//Chequear si hay empleado en la sesión
session_start();
if(isset($_SESSION['usuario'])){
	//Hay empleado conectado
	$empleado = $_SESSION['usuario'];
}
else{
	//Redirigir a login
	header('location:login.php');
}
if(isset($_POST['cerrar'])){
	session_destroy();
	header('location:login.php');
}
if(isset($_POST['Enviar'])){
	if(empty($_POST['asunto']) or empty($_POST['mensaje'])){
		$mensaje = 'Error, rellena asunto y mensaje';
	}
	else{
		$m = new Mensaje(0,$empleado->getIdEmp(),$_POST['para'],
		$_POST['asunto'],date('Y-m-d'),$_POST['mensaje']);
		$destinarios = $bd->obtenerEmpleadosDepartamento($_POST['para']);
		//El id del mensaje generado se puede recuperar de dos formas
		//Bien que lo devuelva el método enviarMensaje
		//o actualizándolo en el objeto $m
		$id=$bd->enviarMensaje($m,$destinarios);
		if($id!=0){
			$mensaje = 'Mensaje nº '.$m->getIdMen().' enviado';
			$mensaje .= '<br/>Mensaje nº '.$id.' enviado';
		}
		else{
			$mensaje = 'Error, mensaje no enviado';
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
        	<form action="mensajes.php" method="post">              	
            		<h1 style="color:blue;">
					Nuevo Mensaje
					</h1> 
            		<h2 style="color:blue;">
					<?php
					echo 'Nombre:'.$empleado->getNombre().'-'.
					'DNI:'.$empleado->getDni().'- Departamento:'.
					$empleado->getDepartamento()->getNombre();
					?>
					</h2>             		
            		<hr/> 
            		<div> 
                		<label for="para">Para</label><br/>           		
                        <select id="para" name="para">
							<?php
							$departamentos = $bd->obtenerDepartamentos();
							foreach($departamentos as $d){
								echo '<option value="'.$d->getIdDep().'">'.$d->getNombre().'</option>';	
							}
							?>
                        </select>  
                    </div>  
            		<div> 
                		<label for="asunto">Asunto</label><br/>           		
                        <input type="text" id="asunto" name="asunto" size="50" maxlength="50"/>  
                    </div>
                    <div> 
                		<label for="mensaje">Mensaje</label><br/>           		
                        <input type="text" id="mensaje" name="mensaje"  size="100" maxlength="100"/>  
                    </div>                               
                    <br/><button type="submit" name="Enviar">Enviar</button>
                    <button type="submit" name="cerrar">Cerrar Sesión</button>
                    <hr/> 
            		<h1 style="color:blue;">Bandeja de Entrada</h1> 
            		<hr/>   
            		<table width="100%">
            			<tr>
            				<th align="left">Id</th>
            				<th align="left">De</th>
            				<th align="left">Para Departamento</th>
            				<th align="left">Fecha</th>
            				<th align="left">Asunto</th>
            				<th align="left">Mensaje</th>
            			</tr>
						<?php
						$mensajesRecibidos = 
							$bd->obtenerMensajesRecidos($empleado);
						foreach($mensajesRecibidos as $m){
							echo '<tr>';
							echo '<td align="left">'.$m->getIdMen().'</td>';
            				echo '<td align="left">'.
							$m->getDeEmpleado()->getNombre().'</td> '; 
							echo '<td align="left">'.
							$m->getParaDepartamento()->getNombre().'</td> ';          				
            				echo '<td align="left">'.
							date('d/m/Y',strtotime($m->getFechaEnvio())).'</td>';
            				echo '<td align="left">'.$m->getAsunto().'</td>';
            				echo '<td align="left">'.$m->getMensaje().'</td>';
							echo '</tr>';
						}
						?>
            		</table>
            		<h1 style="color:blue;">Bandeja de Salida</h1> 
            		<hr/>   
            		<table width="100%">
            			<tr>
            				<th align="left">Id</th>
            				<th align="left">Para</th>            				
            				<th align="left">Fecha</th>
            				<th align="left">Asunto</th>
            				<th align="left">Mensaje</th>
            			</tr>
						<?php 
						$mensajes = $bd->obtenerMensajes($empleado);
						foreach($mensajes as $m){
							echo '<tr>';
							echo '<td align="left">'.$m->getIdMen().'</td>';
            				echo '<td align="left">'.
							$m->getParaDepartamento()->getNombre().'</td> ';           				
            				echo '<td align="left">'.
							date('d/m/Y',strtotime($m->getFechaEnvio())).'</td>';
            				echo '<td align="left">'.$m->getAsunto().'</td>';
            				echo '<td align="left">'.$m->getMensaje().'</td>';
							echo '</tr>';
						}
						?>
            		</table>                              
      		</form>     
		      
	</body>
</html>
