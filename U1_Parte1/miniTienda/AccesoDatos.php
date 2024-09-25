<?php

require_once 'Ticket.php';

class AccesoDatos{
    private $nombre;

    function __construct($n)
    {
        $this->nombre=$n;
    }

    function insertarProducto(Ticket $t){
        //Abrir el fichero
        $fichero = fopen($this->nombre,'a+');

        //Insertar al final
        fwrite($fichero, $t->getProducto().';'.$t->getPrecioU().';'.$t->getCantidad().
            ';'.$t->getTotal().PHP_EOL);

        //Cerrar el fichero
        fclose($fichero);

    }

    function obtenerProductos(){
        $resultado=array();

        //Cargamos el fichero en un array
        $tmp = file($this->nombre);
        foreach($tmp as $linea){
            $campos=explode(';',$linea);
            //Crear objeto ticket
            $t=new Ticket($campos[0],$campos[1],$campos[2]);
            //añadimos $t al array de objetos resultado
            $resultado[]=$t;
        }

        return $resultado;
    }

    /**
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }
}
?>