<?php
class Prestamo{
    private $id, $socio, $libro, $fechaP, $fechaD, $fechaRD;

    function __construct($id, $socio, $libro, $fechaP, $fechaD, $fechaRD){
        $this->id=$id; 
        $this->socio=$socio; 
        $this->libro=$libro; 
        $this->fechaP=$fechaP;
        $this->fechaD=$fechaD; 
        $this->fechaRD=$fechaRD;
    }

    /**
     * Get the value of socio
     */ 
    public function getSocio()
    {
        return $this->socio;
    }

    /**
     * Set the value of socio
     *
     * @return  self
     */ 
    public function setSocio($socio)
    {
        $this->socio = $socio;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of libro
     */ 
    public function getLibro()
    {
        return $this->libro;
    }

    /**
     * Set the value of libro
     *
     * @return  self
     */ 
    public function setLibro($libro)
    {
        $this->libro = $libro;

        return $this;
    }

    /**
     * Get the value of fechaP
     */ 
    public function getFechaP()
    {
        return $this->fechaP;
    }

    /**
     * Set the value of fechaP
     *
     * @return  self
     */ 
    public function setFechaP($fechaP)
    {
        $this->fechaP = $fechaP;

        return $this;
    }

    /**
     * Get the value of fechaD
     */ 
    public function getFechaD()
    {
        return $this->fechaD;
    }

    /**
     * Set the value of fechaD
     *
     * @return  self
     */ 
    public function setFechaD($fechaD)
    {
        $this->fechaD = $fechaD;

        return $this;
    }

    /**
     * Get the value of fechaRD
     */ 
    public function getFechaRD()
    {
        return $this->fechaRD;
    }

    /**
     * Set the value of fechaRD
     *
     * @return  self
     */ 
    public function setFechaRD($fechaRD)
    {
        $this->fechaRD = $fechaRD;

        return $this;
    }
}
?>