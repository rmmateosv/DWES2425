<?php
class ServicioUsuario {
    private $id;
    private $beneficiario;
    private $servicio;
    private $fecha;

    public function __construct($id = null, $beneficiario = null, $servicio = null, $fecha = null) {
        $this->id = $id;
        $this->beneficiario = $beneficiario;
        $this->servicio = $servicio;
        $this->fecha = $fecha;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getBeneficiario() {
        return $this->beneficiario;
    }

    public function setBeneficiario($beneficiario) {
        $this->beneficiario = $beneficiario;
    }

    public function getServicio() {
        return $this->servicio;
    }

    public function setServicio($servicio) {
        $this->servicio = $servicio;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }
}


?>