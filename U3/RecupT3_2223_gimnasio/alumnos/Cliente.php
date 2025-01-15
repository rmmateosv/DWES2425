<?php

class Cliente
{
    private $id,$usuario,$dni,$apellidos,$nombre,$telf,$baja;
    
    public function __construct($id,$usuario,$dni,$apellidos,$nombre,$telf,$baja)
    {
        $this->id=$id;
        $this->usuario=$usuario;
        $this->dni=$dni;
        $this->apellidos=$apellidos;
        $this->nombre=$nombre;
        $this->telf=$telf;
        $this->baja=$baja;
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
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @return mixed
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * @return mixed
     */
    public function getApellidos()
    {
        return $this->apellidos;
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
    public function getTelf()
    {
        return $this->telf;
    }

    /**
     * @return mixed
     */
    public function getBaja()
    {
        return $this->baja;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @param mixed $dni
     */
    public function setDni($dni)
    {
        $this->dni = $dni;
    }

    /**
     * @param mixed $apellidos
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @param mixed $telf
     */
    public function setTelf($telf)
    {
        $this->telf = $telf;
    }

    /**
     * @param mixed $baja
     */
    public function setBaja($baja)
    {
        $this->baja = $baja;
    }
    /**
     * @return mixed
     */
    


    
}

