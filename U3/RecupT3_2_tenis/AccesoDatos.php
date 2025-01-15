<?php

class AccesoDatos
{
    private $conexion=null;
    private $url = "mysql:host=localhost;port=3306;dbname=tenis";
    private $usuario = "root";
    private $clave = "root";
    
    public function __construct()
    {
        try {
            $this->conexion = new PDO($this->url, $this->usuario, $this->clave);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function obtenerJugados($codigo){
        $resultado = 0;
        try {
            $consulta = $this->conexion->prepare("select count(*) from partido 
                                       where finalizado=true and (jugador1 = ? or jugador2 = ?)");
            $params = array($codigo,$codigo);
            $consulta->execute($params);
            while($fila=$consulta->fetch()){
                $resultado=$fila[0];
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }
    public function obtenerPartidos(){
        $resultado = array();
        try {
            $consulta = $this->conexion->query("select * from partido");
            while($fila=$consulta->fetch()){
                $resultado[]=new Partido($fila["codigo"], $fila["jugador1"], 
                    $fila["jugador2"], $fila["fecha"],$fila["numSets"],$fila["finalizado"]);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
            return $resultado;
    }
    public function obtenerPartido($codigo){
        $resultado = null;
        try {
            $consulta = $this->conexion->prepare("select * from partido where codigo=?");
            $params = array($codigo);
            $consulta->execute($params);
            while($fila=$consulta->fetch()){
                $resultado=new Partido($fila["codigo"], $fila["jugador1"],
                    $fila["jugador2"], $fila["fecha"],$fila["numSets"],$fila["finalizado"]);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }
    public function obtenerJugador($nombre){
        $resultado = null;
        try {
            $consulta = $this->conexion->prepare("select * from jugador where nombre=?");
            $params = array($nombre);
            $consulta->execute($params);
            while($fila=$consulta->fetch()){
                $resultado=new Jugador($fila["nombre"], $fila["ganados"]);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }
    public function obtenerResultadosPartido($codigo) {
        $resultado = array();
        try {
            $consulta = $this->conexion->prepare("select * from resultadoPartido where partido=?");
            $params = array($codigo);
            $consulta->execute($params);
            while($fila=$consulta->fetch()){
                $resultado[]=new ResultadoPartido($fila["partido"], $fila["numSet"], 
                    $fila["juegosJ1"], $fila["juegosJ2"]);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }
    public function guardarSet($codigo, $set, $juegosJ1, $juegosJ2) {
        $resultado = false;
        try {
            $consulta = $this->conexion->prepare("insert into resultadoPartido values(?,?,?,?)");
            $params = array($codigo, $set, $juegosJ1, $juegosJ2);
            return($consulta->execute($params));
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }
    public function actualizarEstadistica($partido,$ganador) {
        $resultado = false;
        try {
            $this->conexion->beginTransaction();
            $consulta = $this->conexion->prepare("update partido set finalizado=true where codigo = ?");
            $params = array($partido);
            $ok=($consulta->execute($params));
            if($ok){
                //Puntuaciones
                $consulta = $this->conexion->prepare("update jugador set ganados=ganados + 1 where nombre = ?");
                $params = array($ganador);
                $ok=($consulta->execute($params));
                if($ok){
                    $this->conexion->commit();
                    $resultado=true;               
                }else{
                    $this->conexion->rollBack();
                }
            }
            
        } catch (PDOException $e) {
            $this->conexion->rollBack();
            echo $e->getMessage();
        }
        return $resultado;
    }
    
    /**
     * @return PDO
     */
    public function getConexion()
    {
        return $this->conexion;
    }
    
    /**
     * @param PDO $conexion
     */
    public function setConexion($conexion)
    {
        $this->conexion = $conexion;
    }
}

