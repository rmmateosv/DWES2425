<?php

class Departamento
{
    private $idDep, $nombre;
    
    public function __construct($idDep, $nombre)
    {
        $this->idDep=$idDep;
        $this->nombre=$nombre;
    }
    /**
     * @return mixed
     */
    public function getIdDep()
    {
        return $this->idDep;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $idDep
     */
    public function setIdDep($idDep)
    {
        $this->idDep = $idDep;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    
    
}

