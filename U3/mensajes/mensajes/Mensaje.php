<?php

class Mensaje
{
    private $idMen, $deEmpleado, $paraDepartamento, $asunto, $fechaEnvio, $mensaje;
    public function __construct($idMen, $deEmpleado, $paraDepartamento, $asunto, $fechaEnvio, $mensaje)
    {
        $this->idMen=$idMen; 
        $this->deEmpleado=$deEmpleado;
        $this->paraDepartamento=$paraDepartamento;
        $this->asunto=$asunto;
        $this->fechaEnvio=$fechaEnvio;
        $this->mensaje=$mensaje;
    }
    /**
     * @return mixed
     */
    public function getIdMen()
    {
        return $this->idMen;
    }

    /**
     * @return mixed
     */
    public function getDeEmpleado()
    {
        return $this->deEmpleado;
    }

    /**
     * @return mixed
     */
    public function getParaDepartamento()
    {
        return $this->paraDepartamento;
    }

    /**
     * @return mixed
     */
    public function getAsunto()
    {
        return $this->asunto;
    }

    /**
     * @return mixed
     */
    public function getFechaEnvio()
    {
        return $this->fechaEnvio;
    }

    /**
     * @return mixed
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }

    /**
     * @param mixed $idMen
     */
    public function setIdMen($idMen)
    {
        $this->idMen = $idMen;
    }

    /**
     * @param mixed $deEmpleado
     */
    public function setDeEmpleado($deEmpleado)
    {
        $this->deEmpleado = $deEmpleado;
    }

    /**
     * @param mixed $paraDepartamento
     */
    public function setParaDepartamento($paraDepartamento)
    {
        $this->paraDepartamento = $paraDepartamento;
    }

    /**
     * @param mixed $asunto
     */
    public function setAsunto($asunto)
    {
        $this->asunto = $asunto;
    }

    /**
     * @param mixed $fechaEnvio
     */
    public function setFechaEnvio($fechaEnvio)
    {
        $this->fechaEnvio = $fechaEnvio;
    }

    /**
     * @param mixed $mensaje
     */
    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;
    }

    
}