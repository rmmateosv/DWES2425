<?php
class Beneficiario {
    private $id;
    private $dni;
    private $nombre;
    private $fechaN;
    private $direccion;
    private $centro;

    public function __construct($id = null, $dni = null, $nombre = null, $centro = null, $fechaN = null, $direccion = null) {
        $this->id = $id;
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->fechaN = $fechaN;
        $this->direccion = $direccion;
        $this->centro = $centro;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getDni() {
        return $this->dni;
    }

    public function setDni($dni) {
        $this->dni = $dni;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getFechaN() {
        return $this->fechaN;
    }

    public function setFechaN($fechaN) {
        $this->fechaN = $fechaN;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function getCentro() {
        return $this->centro;
    }

    public function setCentro($centro) {
        $this->centro = $centro;
    }
}


?>