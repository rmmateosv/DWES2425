<?php

class ResultadoPartido
{
    private $partido, $numSet, $juegosJ1, $juegosJ2;
    public function __construct($partido, $numSet, $juegosJ1, $juegosJ2)
    {
        $this->partido=$partido;
        $this->numSet=$numSet; 
        $this->juegosJ1=$juegosJ1; 
        $this->juegosJ2=$juegosJ2;
    }
    /**
     * @return mixed
     */
    public function getPartido()
    {
        return $this->partido;
    }

    /**
     * @return mixed
     */
    public function getNumSet()
    {
        return $this->numSet;
    }

    /**
     * @return mixed
     */
    public function getJuegosJ1()
    {
        return $this->juegosJ1;
    }

    /**
     * @return mixed
     */
    public function getJuegosJ2()
    {
        return $this->juegosJ2;
    }

    /**
     * @param mixed $partido
     */
    public function setPartido($partido)
    {
        $this->partido = $partido;
    }

    /**
     * @param mixed $numSet
     */
    public function setNumSet($numSet)
    {
        $this->numSet = $numSet;
    }

    /**
     * @param mixed $juegosJ1
     */
    public function setJuegosJ1($juegosJ1)
    {
        $this->juegosJ1 = $juegosJ1;
    }

    /**
     * @param mixed $juegosJ2
     */
    public function setJuegosJ2($juegosJ2)
    {
        $this->juegosJ2 = $juegosJ2;
    }

    
}

