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
        return $resultado;
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
    function obtenerPrueba($idP){
        $resultado = null;
        try {
            $consulta = $this->conexion->prepare('SELECT * from prueba where id = ?');
            $params = array($idP);
            if ($consulta->execute($params)) {
                while ($fila = $consulta->fetch()) {
                    $resultado= new Prueba(
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
    function obtenerCorrecion($idP, $idA)
    {
        $resultado = null;
        try {
            $consulta = $this->conexion->prepare('SELECT * from correccion where alumno = ? and prueba=?');
            $params = array($idA, $idP);
            if ($consulta->execute($params)) {
                if ($fila = $consulta->fetch()) {
                    $resultado = new Correccion(
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
    function crearCorreccion($idP, $idA, $puntos, $desc)
    {
        $resultado = false;
        try {
            $this->conexion->beginTransaction();
            //Insert
            $consulta = $this->conexion->prepare('INSERT into correccion values(?,?,?,?)');
            $params = array($idA, $idP,$puntos, $desc);
            if ($consulta->execute($params)) {
                //Comprobamos si se ha insertado 1 fila
                if ($consulta->rowCount() == 1) {
                    //Update
                    $consulta = $this->conexion->prepare('UPDATE alumno set puntuacion=puntuacion+?
                     where id = ?');
                    $params = array($puntos,$idA);
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
    function obtenerCalificaciones($idA){
        $resultado = array();
        try {
            $consulta = $this->conexion->prepare('SELECT * from correccion as c
                                                        inner join prueba as p on c.prueba = p.id
                                                        where alumno = ?');
            $params = array($idA);
            if ($consulta->execute($params)) {
                while ($fila = $consulta->fetch()) {
                    $resultado[] = new Correccion(
                        $fila['alumno'],
                        new Prueba($fila['prueba'],$fila['modalidad'],$fila['fecha'],$fila['descripcion'],$fila['puntuacion']),
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
    function finalizarCorreccion($idA){
        $resultado = false;
        try {
            $consulta = $this->conexion->prepare('update alumno set finalizado =true where id = ?');
            $params = array($idA);
            if ($consulta->execute($params) and $consulta->rowCount()==1) {
               $resultado=true; 
            }
        } catch (\Throwable $th) {
            //throw $th;
            echo $th->getMessage();
        }
        return $resultado;
    }
    function obtenerGanadores(){
        $resultado = array();
        try {
            $consulta = $this->conexion->prepare('CALL obtenerGanadores()');
            if ($consulta->execute()) {
                while ($fila = $consulta->fetch()) {
                    $resultado[] = array($fila[0],$fila[1],$fila[2]);
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
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
