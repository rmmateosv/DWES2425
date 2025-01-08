<?php
require_once 'Tienda.php';
require_once 'Producto.php';
class Modelo{
    private string $url='mysql:host=localhost;port=3306;dbname=mcDaw';
    private string $us = 'root';
    private string $ps = 'root';

    private $conexion=null;

    function __construct()
    {
        try{
            $this->conexion = new PDO($this->url,$this->us,$this->ps);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    function datosPedido($codigoPed){
        $resultado = array();
        try{
            $consulta = $this->conexion->prepare('call datosPedido(?)');
            $params = array($codigoPed);
            if($consulta->execute($params)){
                if($fila=$consulta->fetch()){
                    $resultado[]=$fila[0];
                    $resultado[]=$fila[1];
                    $resultado[]=$fila[2];
                }
            }
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        return $resultado;
    }
    function crearPedido($tienda,$cesta){
        $resultado=0;
        try{
            $this->conexion->beginTransaction();
            $consulta = $this->conexion->prepare(
                'insert into pedido values (default, curdate(),?)');
            $params = array($tienda->getCodigo());
            if($consulta->execute($params)){
                if($consulta->rowCount()==1){
                    $codigoPedido = $this->conexion->lastInsertId();
                    $linea = 1;
                    foreach($cesta as $pc){
                        $consulta = $this->conexion->prepare(
                            'insert into detalle values (?,?,?,?,?)');
                        $params = array($linea,$codigoPedido,$pc->getProducto()->getCodigo(),$pc->getCantidad(),$pc->getProducto()->getPrecio());
                        $linea++;
                        if($consulta->execute($params)){
                            if($consulta->rowCount()!=1){
                                $this->conexion->rollBack();
                                return 0;
                            }
                        }
                    }
                    $resultado = $codigoPedido;
                    $this->conexion->commit();
                }
            }
        }catch(PDOException $e){
            $this->conexion->rollBack();
            echo $e->getMessage();
        }
        return $resultado;
    }
    function obtenerProducto($codigo){
        $resultado=null;
        try{
            $consulta = $this->conexion->prepare(
                'select * from producto where codigo = ?');
            $params = array($codigo);
            if($consulta->execute($params)){
                if($fila=$consulta->fetch()){
                    $resultado=new Producto($fila['codigo'],
                                    $fila['nombre'],$fila['precio']);
                }
            }
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        return $resultado;
    }
    function obtenerProductos(){
        $resultado=array();
        try{
            $consulta = $this->conexion->prepare(
                'select * from producto');
           
            if($consulta->execute()){
                while($fila=$consulta->fetch()){
                    $resultado[]=new Producto($fila['codigo'],
                                    $fila['nombre'],$fila['precio']);
                }
            }
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        return $resultado;
    }
    function obtenerTienda($codigo){
        $resultado=null;
        try{
            $consulta = $this->conexion->prepare(
                'select * from tienda where codigo = ?');
            $params = array($codigo);
            if($consulta->execute($params)){
                if($fila=$consulta->fetch()){
                    $resultado=new Tienda($fila['codigo'],
                                    $fila['nombre'],$fila['telefono']);
                }
            }
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        return $resultado;
    }
    function obtenerTiendas(){
        $resultado=array();
        try{
            $consulta = $this->conexion->prepare(
                'select * from tienda');
           
            if($consulta->execute()){
                while($fila=$consulta->fetch()){
                    $resultado[]=new Tienda($fila['codigo'],
                                    $fila['nombre'],$fila['telefono']);
                }
            }
        }catch(PDOException $e){
            echo $e->getMessage();
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
     */
    public function setConexion($conexion): self
    {
        $this->conexion = $conexion;

        return $this;
    }
}
?>