<!doctype html>
<html>
      <head>
        <meta charset="utf-8">        
        <title>Recuperación T3 22_23</title>
       </head>
     <body>     		
     		<form action="" method="post">    
     			<h1 style="color:blue;">INSCRIBITE EN LAS ACTIVIDADES QUE TE GUSTEN</h1> 
        		<h2 style="color:blue;">Cliente:X - Nombre y apellidos </h2> 
         		<div> 
                    <h3 style='color:red;'>Mensaje</h3> 
                </div>            	                      
            	<label>Actividad</label>	
            	<select id="actividad" name="actividad" onchange="this.form.submit()">
                        
                </select>
                <label>Coste Mensual</label>  	
                <input type="number" value="" disabled="disabled"/>
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
      		</table>       	
    		<hr/> 	      
	</body>
</html>
