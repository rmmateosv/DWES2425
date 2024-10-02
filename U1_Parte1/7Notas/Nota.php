<?php
class Nota{
    private $asi,$fecha,$tipo,$desc,$nota;

    function __construct($asi,$fecha,$tipo,$desc,$nota)
    {
        $this->asi=$asi;
        $this->fecha=$fecha;
        $this->tipo=$tipo;
        $this->desc=$desc;
        $this->nota=$nota;
    }

    

    /**
     * Get the value of asi
     */ 
    public function getAsi()
    {
        return $this->asi;
    }

    /**
     * Set the value of asi
     *
     * @return  self
     */ 
    public function setAsi($asi)
    {
        $this->asi = $asi;

        return $this;
    }

    /**
     * Get the value of fecha
     */ 
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set the value of fecha
     *
     * @return  self
     */ 
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get the value of tipo
     */ 
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set the value of tipo
     *
     * @return  self
     */ 
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get the value of desc
     */ 
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * Set the value of desc
     *
     * @return  self
     */ 
    public function setDesc($desc)
    {
        $this->desc = $desc;

        return $this;
    }

    /**
     * Get the value of nota
     */ 
    public function getNota()
    {
        return $this->nota;
    }

    /**
     * Set the value of nota
     *
     * @return  self
     */ 
    public function setNota($nota)
    {
        $this->nota = $nota;

        return $this;
    }
}

?>