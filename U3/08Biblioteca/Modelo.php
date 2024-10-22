<?php
require_once 'Usuario.php';
require_once 'Socio.php';
require_once 'Libro.php';

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