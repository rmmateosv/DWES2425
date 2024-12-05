<?php
class Correccion
{
    private $alumno;
    private $prueba;
    private $puntos;
    private $comentario;

    function __construct($alumno, $prueba, $puntos, $comentario)
    {
        $this->alumno = $alumno;
        $this->prueba = $prueba;
        $this->puntos = $puntos;
        $this->comentario = $comentario;
    }

    /**
     * Get the value of alumno
     */
    public function getAlumno()
    {
        return $this->alumno;
    }

    /**
     * Set the value of alumno
     *
     * @return  self
     */
    public function setAlumno($alumno)
    {
        $this->alumno = $alumno;

        return $this;
    }

    /**
     * Get the value of prueba
     */
    public function getPrueba()
    {
        return $this->prueba;
    }

    /**
     * Set the value of prueba
     *
     * @return  self
     */
    public function setPrueba($prueba)
    {
        $this->prueba = $prueba;

        return $this;
    }

    /**
     * Get the value of puntos
     */
    public function getPuntos()
    {
        return $this->puntos;
    }

    /**
     * Set the value of puntos
     *
     * @return  self
     */
    public function setPuntos($puntos)
    {
        $this->puntos = $puntos;

        return $this;
    }

    /**
     * Get the value of comentario
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * Set the value of comentario
     *
     * @return  self
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;

        return $this;
    }
}
