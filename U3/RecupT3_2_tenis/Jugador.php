<?php

class Jugador
{
    private $nombre, $ganados;
    
    public function __construct($nombre, $ganados)
    {
        $this->nombre=$nombre;
        $this->ganados=$ganados;

    }
    
    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @return mixed
     */
    public function getGanados()
    {
        return $this->ganados;
    }

    

    

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @param mixed $ganados
     */
    public function setGanados($ganados)
    {
        $this->ganados = $ganados;
    }

    
}

