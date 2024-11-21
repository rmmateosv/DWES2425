<?php
class Modelo{

    private $conexion = null;
    
    function __construct()
    {
        try {
            //code...
            $this->conexion=new PDO('mysql:host=localhost;port=3306;dbname=skills',
                'root','root');
        } catch (\Throwable $th) {
            //throw $th;
            echo $th->getMessage();
        }
    }

    /**
     * Get the value of conexion
     */ 
    public function getConexion()
    {
        return $this->conexion;
    }

    /**
     * Set the value of conexion
     *
     * @return  self
     */ 
    public function setConexion($conexion)
    {
        $this->conexion = $conexion;

        return $this;
    }
}
?>