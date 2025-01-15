<?php

class AD{
    private $conexion=null;
    private $url = "mysql:host=localhost;port=3306;dbname=gimnasio";
    private $usuario = "root";
    private $clave = "root";
    
    public function __construct(){
        try {
            $this->conexion = new PDO($this->url, $this->usuario, $this->clave);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function crearCliente($usuario,$nombre,$ape,$dni,$telef){
        $resultado = false;
        try {
            $this->conexion->beginTransaction();
            $consulta = $this->conexion->prepare("insert into usuario values(?,sha2(?,0),'C')");
            $params=array($usuario,$dni);
            if($consulta->execute($params)){
                $resultado = true;
                $consulta = $this->conexion->prepare("insert into cliente 
                    values(null,?,?,?,?,?,false)");
                $params=array($usuario,$dni,$ape,$nombre,$telef);
                if($consulta->execute($params)){
                    $resultado = true;
                    $this->conexion->commit();
                }
                else{
                    $this->conexion->rollBack();
                }
            }
            else{
                $this->conexion->rollBack();                
            }
        } catch (PDOException $e) {
            $this->conexion->rollBack();
            echo $e->getMessage();
        }
        return $resultado;
    }
    public function BajaActividad($idC,$idA){
        $resultado = false;
        try {
            
            $consulta = $this->conexion->prepare("delete from participa where actividad_id=? and cliente_id = ?");
            $params=array($idA,$idC);
            if($consulta->execute($params)){
                $resultado = true;
            }                      
        } catch (PDOException $e) {
           
            echo $e->getMessage();
        }
        return $resultado;
    }
    
    public function ContratarActividad($idC,$idA){
        $resultado = false;
        try {
            $consulta = $this->conexion->prepare("insert into participa values(?,?)");
            $params=array($idA,$idC);
            if($consulta->execute($params)){  
                $resultado = true;                 
            }           
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }
    public function existeActividadContratada($idC,$idA){
        $resultado = false;
        try {
            $consulta = $this->conexion->prepare("select * from participa
                where cliente_id=? and actividad_id=?");
            $params=array($idC,$idA);
            $consulta->execute($params);
            if($fila=$consulta->fetch()){
                $resultado = true;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }
    public function obtenerContratadas($idC){
        $resultado = array();
        try {
            $consulta = $this->conexion->prepare("select a.* from participa p inner join actividad a
                on a.id = p.actividad_id 
                where p.cliente_id=?");
            $params=array($idC);
            $consulta->execute($params);
            while($fila=$consulta->fetch()){
                $resultado[] = new Actividad($fila["id"], $fila["nombre"], $fila["coste_mensual"], true);
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }
    public function obtenerPrimeraActividad(){
        $resultado = null;
        try {
            $consulta = $this->conexion->prepare("select * from actividad
                order by nombre limit 1");
            $consulta->execute();
            if($fila=$consulta->fetch()){
                $resultado = new Actividad($fila["id"], $fila["nombre"], $fila["coste_mensual"], $fila["activa"]);
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }
    public function obtenerActividad($id){
        $resultado = null;
        try {
            $consulta = $this->conexion->prepare("select * from actividad
                where id=$id");
            $params = array($id);
            $consulta->execute($params);
            if($fila=$consulta->fetch()){
                $resultado = new Actividad($fila["id"], $fila["nombre"], $fila["coste_mensual"], $fila["activa"]);
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }
    public function obtenerActividades(){
        $resultado = array();
        try {
            $consulta = $this->conexion->query("select * from actividad
                where activa=true order by nombre");            
            while($fila=$consulta->fetch()){
                $resultado[] = new Actividad($fila["id"], $fila["nombre"], $fila["coste_mensual"], true);
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }
    public function existeUsuario($us,$dni){
        $resultado = null;
        try {
            $consulta = $this->conexion->prepare("select * from usuario
                where usuario = ? or dni=?");
            $params = array($us,$dni);
            $consulta->execute($params);
            if($fila=$consulta->fetch()){
                $resultado = true;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }
    public function obtenerUsuario($us,$ps){
        $resultado = null;
        try {
            $consulta = $this->conexion->prepare("select * from usuario
                where usuario = ? and clave = sha2(?,0)");
            $params = array($us,$ps);
            $consulta->execute($params);
            if($fila=$consulta->fetch()){
                $resultado = new Usuario($fila['usuario'],$fila['tipo']);              
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }
    public function obtenerCliente($us){
        $resultado = null;
        try {
            $consulta = $this->conexion->prepare("select * from cliente                 
                where usuario = ?");
            $params = array($us);
            $consulta->execute($params);
            if($fila=$consulta->fetch()){                
                $resultado = new Cliente($fila['id'],$fila['usuario'],$fila['dni'],
                    $fila['apellidos'],$fila['nombre'],$fila['telf'],$fila['baja']);              
            }
        } catch (PDOException $e) {
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
?>