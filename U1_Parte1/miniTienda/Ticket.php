<?php

class Ticket{
    private $producto;
    private $precioU;
    private $cantidad;
    private $total;

    function __construct($p,$pU,$c){
        $this->producto=$p;
        $this->precioU=$pU;
        $this->cantidad=$c;
        $this->total=$pU*$c;
    }
    
    function __destruct(){
        //echo "<h4 style='color:red'>Producto ".$this->producto." destruido</h4>";
    }

    /**
     * Get the value of producto
     */ 
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * Set the value of producto
     *
     * @return  self
     */ 
    public function setProducto($producto)
    {
        $this->producto = $producto;

        return $this;
    }

    /**
     * Get the value of precioU
     */ 
    public function getPrecioU()
    {
        return $this->precioU;
    }

    /**
     * Set the value of precioU
     *
     * @return  self
     */ 
    public function setPrecioU($precioU)
    {
        $this->precioU = $precioU;

        return $this;
    }

    /**
     * Get the value of cantidad
     */ 
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set the value of cantidad
     *
     * @return  self
     */ 
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get the value of total
     */ 
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set the value of total
     *
     * @return  self
     */ 
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }
}
?>