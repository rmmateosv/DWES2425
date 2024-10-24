<?php
require_once 'Usuario.php';
require_once 'Socio.php';
require_once 'Libro.php';
require_once 'Prestamo.php';

class Modelo{
    
    private $conexion=null;

    public function __construct()
    {
        try {
            $config = $this->obtenerDatos();
            if($config!=null){
                //Establecer conexión con la bd
                $this->conexion = new PDO('mysql:host='.$config['urlBD'].
                                ';port='.$config['puerto'].';dbname='.$config['nombreBD'],
                    $config['usBD'],
                    $config['psUS']);
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    private function obtenerDatos(){
        $resultado = array();
        if(file_exists('.config')){
            $datosF = file('.config',FILE_IGNORE_NEW_LINES);
            foreach($datosF as $linea){
                $campos = explode('=',$linea);
                $resultado[$campos[0]] = $campos[1];
            }
        }
        else{
            return null;
        }
        return $resultado;
    }

    public function loguear($us,$ps){
        //Devuelve null si los datos no son correctos
        // y un objeto Usuario si los datos son correctos
        $resultado = null;

        //Ejecutamos la consulta 
        //select * from usuarios where id=nombreUS and ps=psUS cifrada
        try {
            //Preparar consulta
            $consulta = $this->conexion->prepare('SELECT * from usuarios 
                            where id = ? and ps=sha2(?,512)');

            //Rellenar parámetros
            $params = array($us,$ps);

            //Ejecutar consulta
            if($consulta->execute($params)){
                //Recuperar el resultado y transformarlo en un objeto Usuario
                if($fila=$consulta->fetch()){
                    $resultado = new Usuario($fila['id'],$fila['tipo']);
                }
            }
            
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }

        return $resultado;
    }
    function obtenerSocios(){
        //Devuleve un array vacío si no hay socios
        //Si hay socios devuelve un array con objetos Socio
        $resultado=array();
        try {
            $textoConsulta = 'SELECT * from socios  order by nombre';
            //Ejecutar consulta
            $c=$this->conexion->query($textoConsulta);
            if($c){
                //Acceder al resultado de la consulta
                while($fila=$c->fetch()){
                    $resultado[]=new Socio($fila['id'],$fila['nombre'],
                    $fila['fechaSancion'],$fila['email'],$fila['us']);
                }
            }
            
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        return $resultado;
    }

    function obtenerLibros(){
        //Devuleve un array vacío si no hay liros
        //Si hay libros devuelve un array con objetos Libro
        $resultado=array();
        try {
            $textoConsulta = 'SELECT * from libros  order by titulo';
            //Ejecutar consulta
            $c=$this->conexion->query($textoConsulta);
            if($c){
                //Acceder al resultado de la consulta
                while($fila=$c->fetch()){
                    $resultado[]=new Libro($fila['id'],$fila['titulo'],
                    $fila['ejemplares'],$fila['autor']);
                }
            }
            
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        return $resultado;
    }

    public function comprobar($socio,$libro){
        $resultado='ok';
        try {
            //llamar función de la bd comprobarSiPrestar(pSocio int, pLibro int)
            $consulta = $this->conexion->prepare('SELECT comprobarSiPrestar(?,?)');
            $params=array($socio,$libro);
            if($consulta->execute($params)){
                if($fila=$consulta->fetch()){
                    $codigo=$fila[0];
                    switch($codigo){
                        case -1:
                            $resultado='No hay ejemplares del libro o el libro no existe';
                            break;
                        case -2:
                            $resultado='El socio está sancionado o el socio no existe';
                            break;
                        case -3:
                            $resultado='El socio tiene préstamos caducados';
                            break;
                        case -4:
                            $resultado='El socio tiene más de 2 libros prestados';
                            break;
                    }
                }
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        return $resultado;
    }

    public function crearPrestamo($idSocio, $idLibro){
        $resultado=0;
        try {
            //Iniciamos transacción ya que vamos a hacer un
            //Insert y un update
            $this->conexion->beginTransaction();
            //Insert
            $consulta = $this->conexion->prepare('INSERT into prestamos values
                (null,?,?,curdate(), adddate(curdate(), INTERVAL 30  DAY ), null)');
            $params=array($idSocio,$idLibro);
            if($consulta->execute($params)){
                //Comprobamos si se ha insertado 1 fila
                if($consulta->rowCount()==1){
                    //Obtenemos el id del préstamos creado
                    $id = $this->conexion->lastInsertId();
                    //Update
                    $consulta = $this->conexion->prepare('UPDATE libros 
                        set ejemplares=ejemplares-1 where id = ?');
                    $params=array($idLibro);
                    if($consulta->execute($params) and $consulta->rowCount()==1){
                        $this->conexion->commit();
                        $resultado=$id;
                    }
                    else{
                        $this->conexion->rollBack(); //Deshacemos Insert
                    }
                    
                }
            }
        } 
        catch (PDOException $e) {
            $this->conexion->rollBack();
            echo $e->getMessage();
        }
        catch (\Throwable $th) {
            echo $th->getMessage();
        }
        return $resultado;
    }

    public function obtenerPrestamos(){
        $resultado = array();
        try {
            $consulta = $this->conexion->query('SELECT * from prestamos as p
                inner join socios as s on p.socio=s.id 
                inner join libros as l on p.libro=l.id 
                order by p.fechaD desc,  p.id');
            if($consulta){
                while($fila=$consulta->fetch()){
                    //Creamos objeto préstamo, el socio y el libro son OBJETOS
                    $p = new Prestamo($fila[0],
                    new Socio($fila['socio'],$fila['nombre'],
                                    $fila['fechaSancion'],$fila['email'],$fila['us']),
                    new Libro($fila['libro'],$fila['titulo'],$fila['ejemplares'],
                                $fila['autor']),
                    $fila['fechaP'],
                    $fila['fechaD'],
                    $fila['fechaRD']);
                    //Añadimos el préstamo a resultado
                    $resultado[]=$p;
                }
            }
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
?>