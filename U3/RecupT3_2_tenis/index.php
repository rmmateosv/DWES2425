<?php 
require_once 'AccesoDatos.php';
require_once 'Partido.php';
require_once 'Jugador.php';

$ad = new AccesoDatos();
if($ad->getConexion()!=null){

    $partidos = $ad->obtenerPartidos();
    //Si se ha pulsado en resultados
    if(isset($_POST["resultados"])){
        $partido = $ad->obtenerPartido($_POST["partido"]);
        $jugador1= $partido->getJugador1();
        $jugador2=  $partido->getJugador2();
        session_start();
        $_SESSION["partido"]=$partido->getCodigo();
        $_SESSION["jugador1"]= $jugador1;
        $_SESSION["jugador2"]= $jugador2;
        header("location:resultados.php");
    }


?>
<!doctype html>
<html>
      <head>
        <meta charset="utf-8">        
        <title>Recupearción T3 2</title>
       </head>
     <body>
		<h1>Selecciona Partido</h1>
		<form action="" method="post">
    		<select name="partido">
    			<?php 
    			foreach ($partidos as $p){
    			    echo "<option value='".$p->getCodigo()."'>
                   ".$p->getJugador1()."-".$p->getJugador2()." 
                   </option>";
    			}
    			?>
    		</select>
    		<input type="submit" value="Resultados" name="resultados">
		</form>
		
	</body>
</html>
<?php 
}
else{
    echo "Error, no hay conexión";
}
?>
