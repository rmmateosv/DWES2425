<?php
class Prueba
{
    private $id;
    private $modalidad;
    private $fecha;
    private $descripcion;
    private $puntuacion;

    function __construct($id, $modalidad, $fecha, $descripcion, $puntuacion)
    {
        $this->id = $id;
        $this->modalidad = $modalidad;
        $this->fecha = $fecha;
        $this->descripcion = $descripcion;
        $this->puntuacion = $puntuacion;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of modalidad
     */
    public function getModalidad()
    {
        return $this->modalidad;
    }

    /**
     * Set the value of modalidad
     *
     * @return  self
     */
    public function setModalidad($modalidad)
    {
        $this->modalidad = $modalidad;

        return $this;
    }

    /**
     * Get the value of fecha
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set the value of fecha
     *
     * @return  self
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get the value of descripcion
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     *
     * @return  self
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get the value of puntuacion
     */
    public function getPuntuacion()
    {
        return $this->puntuacion;
    }

    /**
     * Set the value of puntuacion
     *
     * @return  self
     */
    public function setPuntuacion($puntuacion)
    {
        $this->puntuacion = $puntuacion;

        return $this;
    }
}
