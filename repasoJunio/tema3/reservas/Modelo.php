<?php
require_once 'Usuarios.php';
require_once 'Recursos.php';
require_once 'Reservas.php';

$mensaje = '';

class Modelo
{
    private $conexion;


    function __construct()
    {
        try {
            $this->conexion = new PDO(
                'mysql:host=localhost;port=3306;dbname=reservas',
                'root',
                'root'
            );
        } catch (\Throwable $th) {
            // echo $th->getMessage();
            global $mensaje;
            $mensaje = $th->getMessage();
        }
    }

    function obtenerUsuario($usuario, $ps)
    {
        $respuesta = null;
        try {
            $consulta = $this->conexion->prepare('SELECT * FROM usuarios WHERE idrayuela=? 
            and ps=sha2(?,512)');
            $params = [$usuario, $ps];
            if ($consulta->execute($params)) {
                if ($fila = $consulta->fetch()) {
                    $respuesta = new Usuarios($fila[0], $fila[1], $fila['activo'], $fila['numReservas']);
                }
            }
        } catch (\Throwable $th) {
            global $mensaje;
            $mensaje = $th->getMessage();
        }

        return $respuesta;
    }
    function obtenerRecursos(){
        $respuesta=array();
        try {
            $consulta=$this->conexion->query('SELECT * from recursos');
        } catch (\Throwable $th) {
            global $mensaje;
            $mensaje = $th->getMessage();
        }
        return $respuesta;
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
