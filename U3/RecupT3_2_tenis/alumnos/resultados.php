<!doctype html>
<html>
      <head>
        <meta charset="utf-8">        
        <title>Recuperación T3 2</title>
       </head>
     <body>
     	<form action="" method="post">
         	<input type="submit" name="cambiar" value="Cambiar Partido"/><hr/>
    		<h1>jugador1/jugador2</h1>
         	<h2 style="color:red;"><?php if(isset($mensaje)) echo $mensaje?></h2>
         	<hr/>
         	<h2 style="color:red;">mensaje si es necesario</h2>
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
    			
    		</table>
    		<hr/>
    		<h2>Estadísticas Jugadores</h2>
    		<table width="50%">
    			<tr>
    				<th align="left">Jugador</th>
    				<th align="left">Ganados</th>
    				<th align="left">Jugados</th>
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
    			<tr>
    				<td><select name="set">
    				</select></td>
    				<td><input type="number" name="juegosJ1"/></td>
    				<td><input type="number" name="juegosJ2"/></td>
    				<td><input type="submit" name="grabarSet" value="Guardar Set"/></td>
    				
    			</tr>
    			<tr>
    				<td></td>
    				<td><input type="radio" name="ganador" value="j1"/>Gana Jugador1</td>
    				<td><input type="radio" name="ganador" value="j2"/>Gana Jugador2</td>
    				<td><input type="submit" name="finPartido" value="Finalizar"/></td>
    			</tr>
    		</table>
		</form>
	</body>
</html>
