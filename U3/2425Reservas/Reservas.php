<?php
class Reservas {
    private $id;
    private $usuario;
    private $recurso;
    private $fecha;
    private $hora;
    private $anulada;

    public function __construct($id = null, $usuario = null, $recurso = null, $fecha = null, $hora = null, $anulada = false) {
        $this->id = $id;
        $this->usuario = $usuario;
        $this->recurso = $recurso;
        $this->fecha = $fecha;
        $this->hora = $hora;
        $this->anulada = $anulada;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function setRecurso($recurso) {
        $this->recurso = $recurso;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function setHora($hora) {
        $this->hora = $hora;
    }

    public function setAnulada($anulada) {
        $this->anulada = $anulada;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getRecurso() {
        return $this->recurso;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getHora() {
        return $this->hora;
    }

    public function getAnulada() {
        return $this->anulada;
    }
}
?>
