<?php

class Actividad
{
    private $id, $nombre, $coste_mensual, $activa;
    public function __construct($id, $nombre, $coste_mensual, $activa)
    {
        $this->id=$id; 
        $this->nombre=$nombre; 
        $this->coste_mensual=$coste_mensual; 
        $this->activa=$activa;
    }
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
    public function getCoste_mensual()
    {
        return $this->coste_mensual;
    }

    /**
     * @return mixed
     */
    public function getActiva()
    {
        return $this->activa;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @param mixed $coste_mensual
     */
    public function setCoste_mensual($coste_mensual)
    {
        $this->coste_mensual = $coste_mensual;
    }

    /**
     * @param mixed $activa
     */
    public function setActiva($activa)
    {
        $this->activa = $activa;
    }

    
    
}

