<?php

class Empleado
{
    private $idEmp, $dni, $nombre, $fechaNac, $departamento, $cambiarPs;
    public function __construct($idEmp, $dni, $nombreEmp, $fechaNac, $departamento, $cambiarPs)
    {
        $this->idEmp=$idEmp; 
        $this->dni=$dni; 
        $this->nombre=$nombreEmp; 
        $this->fechaNac=$fechaNac; 
        $this->departamento=$departamento; 
        $this->cambiarPs=$cambiarPs;
    }
    /**
     * @return mixed
     */
    public function getIdEmp()
    {
        return $this->idEmp;
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
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @return mixed
     */
    public function getFechaNac()
    {
        return $this->fechaNac;
    }

    /**
     * @return mixed
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

    /**
     * @return mixed
     */
    public function getCambiarPs()
    {
        return $this->cambiarPs;
    }

    /**
     * @param mixed $idEmp
     */
    public function setIdEmp($idEmp)
    {
        $this->idEmp = $idEmp;
    }

    /**
     * @param mixed $dni
     */
    public function setDni($dni)
    {
        $this->dni = $dni;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @param mixed $fechaNac
     */
    public function setFechaNac($fechaNac)
    {
        $this->fechaNac = $fechaNac;
    }

    /**
     * @param mixed $departamento
     */
    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;
    }

    /**
     * @param mixed $cambiarPs
     */
    public function setCambiarPs($cambiarPs)
    {
        $this->cambiarPs = $cambiarPs;
    }

 
    
}

