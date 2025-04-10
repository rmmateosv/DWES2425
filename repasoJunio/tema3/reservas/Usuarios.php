<?php
class Usuarios {
    private $idRayuela;
    private $nombre;
    private $activo;
    private $numReservas;

    public function __construct($idRayuela = null, $nombre = null, $activo = true, $numReservas = 0) {
        $this->idRayuela = $idRayuela;
        $this->nombre = $nombre;
        $this->activo = $activo;
        $this->numReservas = $numReservas;
    }

    // Setters
    public function setIdRayuela($idRayuela) {
        $this->idRayuela = $idRayuela;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }


    public function setNumReservas($numReservas) {
        $this->numReservas = $numReservas;
    }

    // Getters
    public function getIdRayuela() {
        return $this->idRayuela;
    }

    public function getNombre() {
        return $this->nombre;
    }


    public function getNumReservas() {
        return $this->numReservas;
    }

    /**
     * Get the value of activo
     */ 
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set the value of activo
     *
     * @return  self
     */ 
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }
}
?>
