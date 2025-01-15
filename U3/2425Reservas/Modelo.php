<?php
require_once 'Reservas.php';
require_once 'Usuarios.php';
require_once 'Recursos.php';

class Modelo
{
    private string $url = 'mysql:host=localhost;port=3306;dbname=reservas';
    private string $us = 'root';
    private string $ps = 'root';

    private $conexion = null;

    function __construct()
    {
        try {
            $this->conexion = new PDO($this->url, $this->us, $this->ps);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function login($us, $ps)
    {
        $resultado = 0;
        try {
            $consulta = $this->conexion->prepare('SELECT * from usuarios where idRayuela=? and ps=sha2(?,512)');
            $params = array($us, $ps);
            if ($consulta->execute($params)) {
                if ($fila = $consulta->fetch()) {
                    $resultado = new Usuarios($fila['idRayuela'], $fila['nombre'], $fila['activo'], $fila['numReservas']);
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }
    function obtenerUsuario($us)
    {
        $resultado = 0;
        try {
            $consulta = $this->conexion->prepare('SELECT * from usuarios where idRayuela=?');
            $params = array($us);
            if ($consulta->execute($params)) {
                if ($fila = $consulta->fetch()) {
                    $resultado = new Usuarios($fila['idRayuela'], $fila['nombre'], $fila['activo'], $fila['numReservas']);
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }

    function cambiarPS($id, $ps)
    {
        $resultado = false;
        try {
            $consulta = $this->conexion->prepare('UPDATE usuarios set ps=? and cambiar=false');
            $params = array($ps);
            if ($consulta->execute($params)) {
                $resultado = true;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }
    function obtenerRecursos()
    {
        $resultado = array();
        try {
            $consulta = $this->conexion->prepare('SELECT * from recursos');
            if ($consulta->execute()) {
                while ($fila = $consulta->fetch()) {
                    $resultado[] = new Recursos($fila['id'], $fila['nombre'], $fila['tipo'], $fila['descripcion']);
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }
    function obtenerReservasActivas($idR)
    {
        $resultado = array();
        try {
            $consulta = $this->conexion->prepare('SELECT * from reservas r 
                                                    inner join usuarios u on r.usuario = u.idRayuela
                                                    inner join recursos re on re.id=r.recurso and anulada = false 
                                                    where recurso = ?
                                                    order by r.fecha desc');
            $params = array($idR);
            if ($consulta->execute($params)) {
                while ($fila = $consulta->fetch()) {
                    $resultado[] = new Reservas(
                        $fila['0'],
                        new Usuarios($fila['idRayuela'], $fila['7'], $fila['activo'], $fila['numReservas']),
                        new Recursos($fila['recurso'], $fila['12'], $fila['tipo'], $fila['descripcion']),
                        date('d/m/Y',strtotime($fila['fecha'])),
                        $fila['hora']
                    );
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }
    function chequearReservar($recurso,$fecha,$hora)
    {
        $resultado = false;
        try {
            $consulta = $this->conexion->prepare('SELECT disponibilidad(?,?,?)');
            $params = array($recurso,$fecha,$hora);
            if ($consulta->execute($params)) {
                if ($fila = $consulta->fetch() and $fila[0]) {
                    $resultado = true;
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }
    function reservar($recurso,$usuario,$fecha,$hora)
    {
        $resultado = false;
        try {
            $this->conexion->beginTransaction();
            //Insert
            $consulta = $this->conexion->prepare('INSERT into reservas values
                (null,?,?,?,?,false)');
            $params = array($usuario,$recurso,$fecha,$hora);
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
    function anularReserva($recurso,$usuario,$fecha,$hora)
    {
        $resultado = false;
        try {
            $this->conexion->beginTransaction();
            //Insert
            $consulta = $this->conexion->prepare('UPDATE reservas set anulada = true 
            where usuario=? and recurso=? and fecha=? and hora=? and anulada=false');
            $params = array($usuario,$recurso,$fecha,$hora);
            if ($consulta->execute($params)) {
                //Comprobamos si se ha modificado 1 fila
                if ($consulta->rowCount() == 1) {
                    //Update
                    $consulta = $this->conexion->prepare('UPDATE usuarios set numReservas=numReservas-1 
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
    
}
