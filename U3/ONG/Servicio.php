<?php
class Servicio {
    private $id;
    private $nombreServicio;
    private $descripcion;

    public function __construct($id = null, $nombreServicio = null, $descripcion = null) {
        $this->id = $id;
        $this->nombreServicio = $nombreServicio;
        $this->descripcion = $descripcion;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNombreServicio() {
        return $this->nombreServicio;
    }

    public function setNombreServicio($nombreServicio) {
        $this->nombreServicio = $nombreServicio;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
}


?>