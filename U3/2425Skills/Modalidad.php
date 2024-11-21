<?php
class Modalidad
{
    private $id;
    private $modalidad;

    function __construct($id, $modalidad)
    {
        $this->id = $id;
        $this->modalidad = $modalidad;
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
}
