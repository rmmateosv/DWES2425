<?php

class Partido
{
    private $codigo, $jugador1, $jugador2, $fecha, $numSets,$finalizado;
    
    public function __construct($codigo, $jugador1, $jugador2, $fecha, $numSets, $finalizado)
    {
        $this->codigo=$codigo;
        $this->jugador1=$jugador1; 
        $this->jugador2=$jugador2; 
        $this->fecha=$fecha; 
        $this->numSets=$numSets;
        $this->finalizado = $finalizado;
    }
    /**
     * @return mixed
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @return mixed
     */
    public function getJugador1()
    {
        return $this->jugador1;
    }

    /**
     * @return mixed
     */
    public function getJugador2()
    {
        return $this->jugador2;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @return mixed
     */
    public function getNumSets()
    {
        return $this->numSets;
    }

    /**
     * @param mixed $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * @param mixed $jugador1
     */
    public function setJugador1($jugador1)
    {
        $this->jugador1 = $jugador1;
    }

    /**
     * @param mixed $jugador2
     */
    public function setJugador2($jugador2)
    {
        $this->jugador2 = $jugador2;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * @param mixed $numSets
     */
    public function setNumSets($numSets)
    {
        $this->numSets = $numSets;
    }
    /**
     * @return mixed
     */
    public function getFinalizado()
    {
        return $this->finalizado;
    }

    /**
     * @param mixed $finalizado
     */
    public function setFinalizado($finalizado)
    {
        $this->finalizado = $finalizado;
    }


    
    
}

