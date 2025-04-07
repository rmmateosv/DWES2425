<?php

class Entrada{
    private $nombreCliente;
    private $tipoEntrada;
    private $fechaEvento;
    private $NEntradas;
    private $Descuentos;
    private $importe;

    function __construct($n, $t, $f, $ne, $d, $i){
        $this->nombreCliente=$n;
        $this->tipoEntrada=$t;
        $this->fechaEvento=$f;
        $this->NEntradas=$ne;
        $this->Descuentos=$d;
        $this->importe=$i;
    }






    /**
     * Get the value of nombreCliente
     */ 
    public function getNombreCliente()
    {
        return $this->nombreCliente;
    }

    /**
     * Set the value of nombreCliente
     *
     * @return  self
     */ 
    public function setNombreCliente($nombreCliente)
    {
        $this->nombreCliente = $nombreCliente;

        return $this;
    }

    /**
     * Get the value of fechaEvento
     */ 
    public function getFechaEvento()
    {
        return $this->fechaEvento;
    }

    /**
     * Set the value of fechaEvento
     *
     * @return  self
     */ 
    public function setFechaEvento($fechaEvento)
    {
        $this->fechaEvento = $fechaEvento;

        return $this->FechaEvento;
    }

    /**
     * Get the value of NEntradas
     */ 
    public function getNEntradas()
    {
        return $this->NEntradas;
    }

    /**
     * Set the value of NEntradas
     *
     * @return  self
     */ 
    public function setNEntradas($NEntradas)
    {
        $this->NEntradas = $NEntradas;

        return $this;
    }

    /**
     * Get the value of Descuentos
     */ 
    public function getDescuentos()
    {
        return $this->Descuentos;
    }

    /**
     * Set the value of Descuentos
     *
     * @return  self
     */ 
    public function setDescuentos($Descuentos)
    {
        $this->Descuentos = $Descuentos;

        return $this;
    }

    /**
     * Get the value of importe
     */ 
    public function getImporte()
    {
        return $this->importe;
    }

    /**
     * Set the value of importe
     *
     * @return  self
     */ 
    public function setImporte($importe)
    {
        $this->importe = $importe;

        return $this;
    }

    /**
     * Get the value of tipoEntrada
     */ 
    public function getTipoEntrada()
    {
        return $this->tipoEntrada;
    }

    /**
     * Set the value of tipoEntrada
     *
     * @return  self
     */ 
    public function setTipoEntrada($tipoEntrada)
    {
        $this->tipoEntrada = $tipoEntrada;

        return $this;
    }
}

?>