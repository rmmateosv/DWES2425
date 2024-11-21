<?php
class Alumno
{
    private $id;
    private $nombre;
    private $modalidad;
    private $puntuacion;
    private $finalizado;

    function __construct($id, $nombre, $modalidad, $puntuacion, $finalizado)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->modalidad = $modalidad;
        $this->puntuacion = $puntuacion;
        $this->finalizado = $finalizado;
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
     * Get the value of puntuacion
     */


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

    /**
     * Get the value of finalizado
     */
    public function getFinalizado()
    {
        return $this->finalizado;
    }

    /**
     * Set the value of finalizado
     *
     * @return  self
     */
    public function setFinalizado($finalizado)
    {
        $this->finalizado = $finalizado;

        return $this;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

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
}
