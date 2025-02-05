<?php
require_once 'Beneficiario.php';
require_once 'Centro.php';
require_once 'Servicio.php';
require_once 'ServicioUsuario.php';

class Modelo
{
    private $cnx = null;

    function __construct()
    {
        try {
            $this->cnx = new PDO('mysql:host=localhost;port=3306;dbname=ong', 'root', 'root');
        } catch (PDOException $th) {
            echo $th->getMessage();
        }
    }

    /**
     * Get the value of cnx
     */
    public function getCnx()
    {
        return $this->cnx;
    }

    /**
     * Set the value of cnx
     *
     * @return  self
     */
    public function setCnx($cnx)
    {
        $this->cnx = $cnx;

        return $this;
    }

    function obtenerCentros()
    {
        $resultado = array();
        try {
            $consulta = $this->cnx->query('SELECT * from centros');
            while ($fila = $consulta->fetch()) {
                $resultado[] = new Centro($fila['id'], $fila['nombre'], $fila['localidad'], $fila['activo']);
            }
        } catch (PDOException $th) {
            echo $th->getMessage();
        }
        return $resultado;
    }
    function obtenerCentro($id)
    {
        $resultado = null;
        try {
            $consulta = $this->cnx->prepare('SELECT * from centros where id=?');
            $param = array($id);
            if ($consulta->execute($param)) {
                if ($fila = $consulta->fetch()) {
                    $resultado = new Centro($fila['id'], $fila['nombre'], $fila['localidad'], $fila['activo']);
                }
            }
        } catch (PDOException $th) {
            echo $th->getMessage();
        }
        return $resultado;
    }
    function obtenerInfo($id){
        $resultado = array();
        try {
            $consulta = $this->cnx->prepare('call infoCentro(?)');
            $param = array($id);
            if ($consulta->execute($param)) {
                if ($fila = $consulta->fetch()) {
                    $resultado[]=$fila['numBeneficiarios'];
                    $resultado[]=$fila['numServiciosP'];
                }
            }
        } catch (PDOException $th) {
            echo $th->getMessage();
        }
        return $resultado;
    }

    function obtenerBeneficiariosCentro($id)
    {
        $resultado = [];
        try {
            $consulta = $this->cnx->prepare('SELECT * from beneficiarios where centro=? order by nombre');
            $param = array($id);
            if ($consulta->execute($param)) {
                while ($fila = $consulta->fetch()) {
                    $resultado[] = new Beneficiario($fila['id'],$fila['dni'],$fila['nombre'],$fila['centro'],$fila['fechaN'],
                    $fila['direccion']);
                }
            }
        } catch (PDOException $th) {
            echo $th->getMessage();
        }
        return $resultado;
    }
    function obtenerServicios()
    {
        $resultado = array();
        try {
            $consulta = $this->cnx->query('SELECT * from servicios');
            while ($fila = $consulta->fetch()) {
                $resultado[] = new Servicio($fila['id'],$fila['nombre_servicio'],$fila['descripcion']);
            }
        } catch (PDOException $th) {
            echo $th->getMessage();
        }
        return $resultado;
    }
    function obtenerServiciosP($id){
        $resultado = [];
        try {
            $consulta = $this->cnx->prepare('SELECT * 
                from servicio_usuario as su join beneficiarios as b
                    on su.beneficiario = b.id
                    join servicios as s on su.servicio = s.id 
                where su.beneficiario = ?');
            $param = array($id);
            if ($consulta->execute($param)) {
                while ($fila = $consulta->fetch()) {
                    $resultado[] = new ServicioUsuario($fila[0],
                new Beneficiario($fila['beneficiario'],$fila['dni'],
                                  $fila['nombre'],$fila['centro'],$fila['fechaN'],$fila['direccion']),
                new Servicio($fila['servicio'],$fila['nombre_servicio'],$fila['descripcion']),
                $fila['fecha']);
                }
            }
        } catch (PDOException $th) {
            echo $th->getMessage();
        }
        return $resultado;
    }
    function borrarB($id){
        $resultado = false;
        try {
            $this->cnx->beginTransaction();
            $consulta = $this->cnx->prepare('delete from servicio_usuario where beneficiario = ?');
            $param = array($id);
            if($consulta->execute($param)){
                $consulta = $this->cnx->prepare('delete from beneficiarios where id = ?');
                $param = array($id);
                if($consulta->execute($param)){
                    $this->cnx->commit();
                    $resultado = true;
                }
            }
            
        } catch (PDOException $th) {
            $this->cnx->rollback();
            echo $th->getMessage();
        }
        return $resultado;
    }
}
