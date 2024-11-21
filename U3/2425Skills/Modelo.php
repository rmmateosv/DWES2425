<?php
require_once 'Modalidad.php';
require_once 'Alumno.php';
require_once 'Correccion.php';
require_once 'Prueba.php';
class Modelo
{

    private $conexion = null;

    function __construct()
    {
        try {
            //code...
            $this->conexion = new PDO(
                'mysql:host=localhost;port=3306;dbname=skills',
                'root',
                'root'
            );
        } catch (\Throwable $th) {
            //throw $th;
            echo $th->getMessage();
        }
    }
    function obtenerModalidades()
    {
        $resultado = array();
        try {
            $consulta = $this->conexion->query('SELECT * from modalidad');
            while ($fila = $consulta->fetch()) {
                $resultado[] = new Modalidad($fila['id'], $fila['modalidad']);
            }
        } catch (\Throwable $th) {
            //throw $th;
            echo $th->getMessage();
        }
        return $resultado;
    }
    function obtenerModalidad($id)
    {
        $resultado = null;
        try {
            $consulta = $this->conexion->prepare('SELECT * from modalidad where id = ?');
            $params = array($id);
            if ($consulta->execute($params)) {
                if ($fila = $consulta->fetch()) {
                    $resultado = new Modalidad($fila['id'], $fila['modalidad']);
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
            echo $th->getMessage();
        }
        return $resultado;
    }

    function  obtenerAlumnosModalidad($id)
    {
        $resultado = array();
        try {
            $consulta = $this->conexion->prepare('SELECT * from alumno where modalidad = ?');
            $params = array($id);
            if ($consulta->execute($params)) {
                while ($fila = $consulta->fetch()) {
                    $resultado[] = new Alumno(
                        $fila['id'],
                        $fila['nombre'],
                        $fila['modalidad'],
                        $fila['puntuacion'],
                        $fila['finalizado']
                    );
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
            echo $th->getMessage();
        }
        return $resultado;
    }
    function obtenerAlumno($id)
    {
        $resultado = null;
        try {
            $consulta = $this->conexion->prepare('SELECT * from alumno where id = ?');
            $params = array($id);
            if ($consulta->execute($params)) {
                if ($fila = $consulta->fetch()) {
                    $resultado = new Alumno(
                        $fila['id'],
                        $fila['nombre'],
                        $fila['modalidad'],
                        $fila['puntuacion'],
                        $fila['finalizado']
                    );
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
            echo $th->getMessage();
        }
    }

    function obtenerPruebasModalidad($idM)
    {
        $resultado = array();
        try {
            $consulta = $this->conexion->prepare('SELECT * from prueba where modalidad = ?');
            $params = array($idM);
            if ($consulta->execute($params)) {
                while ($fila = $consulta->fetch()) {
                    $resultado[] = new Prueba(
                        $fila['id'],
                        $fila['modalidad'],
                        $fila['fecha'],
                        $fila['descripcion'],
                        $fila['puntuacion']
                    );
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
            echo $th->getMessage();
        }
        return $resultado;
    }
    function obtenerCorrecion($idP,$idA)
    {
        $resultado = array();
        try {
            $consulta = $this->conexion->prepare('SELECT * from correcion where alumno = ? and prueba=?');
            $params = array($idA,idP);
            if ($consulta->execute($params)) {
                while ($fila = $consulta->fetch()) {
                    $resultado[] = new Correccion(
                        $fila['alumno'],
                        $fila['prueba'],
                        $fila['puntos'],
                        $fila['comentario']
                    );
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
            echo $th->getMessage();
        }
        return $resultado;
    }
function crearCorrecion($idP,$idA,$puntos,$desc)
    {
        $resultado = false;
        $this->conexion->beginTransaction();
            //Insert
            $consulta = $this->conexion->prepare('INSERT into correcion values(?,?,?,?)');
            $params = array($idP,$idA,$puntos,$desc);
            if ($consulta->execute($params)) {
                //Comprobamos si se ha insertado 1 fila
                if ($consulta->rowCount() == 1) {
                    //Update
                    $consulta = $this->conexion->prepare('UPDATE usuarios set numReservas=numReservas+1 
                     where idRayuela = ?');
                    $params = array($usuario);
                    if ($consulta->execute($params) and $consulta->rowCount() == 1) {
                        $this->conexion->commit();
                        $resultado = true;
                    } else {
                        $this->conexion->rollBack(); //Deshacemos Insert
                    }
                }
            }
        } catch (PDOException $e) {
            $this->conexion->rollBack();
            echo $e->getMessage();
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        return $resultado;
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
