<?php 
require_once 'AccesoDatos.php';
require_once 'Partido.php';
require_once 'Jugador.php';
require_once 'ResultadoPartido.php';
session_start();
if(isset($_SESSION["partido"]) and isset($_SESSION["jugador1"]) and isset($_SESSION["jugador2"])){
    if(isset($_POST['cambiar'])){
        session_unset();
        header('location:index.php');
    }
    $ad = new AccesoDatos();
    if($ad->getConexion()!=null){
        $partido = $ad->obtenerPartido($_SESSION["partido"]);
        $jugador1 = $ad->obtenerJugador($_SESSION["jugador1"]);
        $jugador2 = $ad->obtenerJugador($_SESSION["jugador2"]);
        if(isset($_POST["grabarSet"])){
            if(empty($_POST['juegosJ1']) or empty($_POST['juegosJ2'])){
                $mensaje = "Error hay que indicar los juegos de los dos jugadores";
            }
            else{
                if(!$ad->guardarSet($partido->getCodigo(), $_POST["set"], $_POST["juegosJ1"], $_POST["juegosJ2"])) {
                    $mensaje = "Error al guardar el set";
                }
            }
        }       
        if(isset($_POST["finPartido"])){
            if(isset($_POST["ganador"]) and $_POST["ganador"]=="j1"){
                if(!$ad->actualizarEstadistica($partido->getCodigo(),$partido->getJugador1())) {
                    $mensaje = "Error al actualizar las estadísiticas";
                }
                else{
                    $partido->setFinalizado(true);
                }
            }
            elseif(isset($_POST["ganador"]) and $_POST["ganador"]=="j2"){
                if(!$ad->actualizarEstadistica($partido->getCodigo(),$partido->getJugador2())) {
                    $mensaje = "Error al actualizar las estadísiticas";
                }
                else{
                    $partido->setFinalizado(true);
                }
            }
            else{
                $mensaje = "Selecciona el ganador";
            }
            
        }
        //Obtener resultados del partido
        $resultados=$ad->obtenerResultadosPartido($partido->getCodigo());
?>
<!doctype html>
<html>
      <head>
        <meta charset="utf-8">        
        <title>Recuperación T3 2</title>
       </head>
     <body>
     	<form action="" method="post">
         	<input type="submit" name="cambiar" value="Cambiar Partido"/>
         	<hr/>
    		<h1><?php echo $_SESSION['jugador1'],"/",$_SESSION['jugador2']?></h1>
         	<h2 style="color:red;"><?php if(isset($mensaje)) echo $mensaje?></h2>
         	<hr/>
    		<h2>Datos del Partido</h2>
    		<table width="50%">
    			<tr>
    				<td><b>Código</b></td>
    				<td><b>Jugador 1</b></td>
    				<td><b>Jugador 2</b></td>
    				<td><b>Fecha</b></td>
    				<td><b>Número de Sets</b></td>
    			</tr>
    			<tr>
    				<td><?php echo $partido->getCodigo()?></td>
    				<td><?php echo $partido->getJugador1()?></td>
    				<td><?php echo $partido->getJugador2()?></td>
    				<td><?php echo $partido->getFecha()?></td>
    				<td><?php echo $partido->getnumSets()?></td>
    			</tr>
    		</table>
    		<hr/>
    		<h2>Estadísticas Jugadores</h2>
    		<table width="50%">
    			<tr>
    				<th align="left">Jugador</th>
    				<th align="left">Ganados</th>
    				<th align="left">Jugados</th>
    			</tr>
    			<tr>
    				<td><?php echo $jugador1->getNombre()?></td>
    				<td><?php echo $jugador1->getGanados()?></td>
    				<td><?php echo $ad->obtenerJugados($jugador1->getNombre())?></td>
    			</tr>
    			<tr>
    				<td><?php echo $jugador2->getNombre()?></td>
    				<td><?php echo $jugador2->getGanados()?></td>
    				<td><?php echo $ad->obtenerJugados($jugador2->getNombre())?></td>
    			</tr>
    		</table>
    		<hr/>
    		
    		<h2>Resultados del Partido</h2>		
        		<table width="50%">
    			<tr>
    				<th align="left">Set</th>
    				<th align="left">Juegos Jugador1</th>
    				<th align="left">Juegos Jugador2</th>
    				<th align="left">Acción</th>
    			</tr>
    			<?php 
    			foreach($resultados as $r){
    			    echo "<tr>
                            <td>".$r->getNumSet()."</td>
                            <td>".$r->getJuegosJ1()."</td>
                            <td>".$r->getJuegosJ2()."</td>
                            <td></td>
                          </tr>";
    			}
    			if(!$partido->getFinalizado()){
    			?>
    			
	
	
    			<tr>
    				<td><select name="set">
    					<?php 
    					for($i=1;$i<=$partido->getNumSets();$i++){
    					    echo "<option>".$i."</option>";
    					}
    					?>
    				</select></td>
    				<td><input type="number" name="juegosJ1"/></td>
    				<td><input type="number" name="juegosJ2"/></td>
    				<td><input type="submit" name="grabarSet" value="Guardar Set"/></td>
    				
    			</tr>
    			<tr>
    				<td></td>
    				<td><input type="radio" name="ganador" value="j1"/>Gana <?php echo $jugador1->getNombre()?></td>
    				<td><input type="radio" name="ganador" value="j2"/>Gana <?php echo $jugador2->getNombre()?></td>
    				<td><input type="submit" name="finPartido" value="Finalizar"/></td>
    			</tr>
    		</table>
		</form>
		<?php }//If no finalizado?>
	</body>
</html>
<?php 
    }
    else{
        echo "Error, no hay conexi�n";
    }
}
else{
    header("location:index.php");
}
?>
