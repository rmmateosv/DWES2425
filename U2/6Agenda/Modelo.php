<?php
require_once 'Contacto.php';

class Modelo{
    private $nombre;

    function __construct($nombreF)
    {
     $this->nombre=$nombreF;   
    }

    function crearContacto(Contacto $c){
        try{
            $f = fopen($this->nombre,'a+');
            fwrite($f,$c->getId().';'.$c->getNombre().';'.$c->getTelefono().';'
            .$c->getTipo().';'.$c->getFoto().PHP_EOL);
        }
        catch(Throwable $t){
            echo $t->getMessage();
        }
        finally{
            fclose($f);
        }
    }

    function obtenerContactos(){
        $resultado = array();
        try {
            if(file_exists($this->nombre)){
                $registros=file($this->nombre);
                foreach($registros as $linea){
                    $campos=explode(';',$linea);
                    $resultado[]=new Contacto($campos[0],$campos[1],
                    $campos[2], $campos[3],$campos[4]);
                }
            }
           
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        return $resultado;
    }
    function obtenerID(){
        $resultado=1;
        try {
            if(file_exists($this->nombre)){
                $registros=file($this->nombre);
                //Obtengo la posición del array del último registro
                $pos=sizeof($registros)-1;
                $campos = explode(';',$registros[$pos]);
                $resultado=$campos[0]+1;
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        
        return $resultado;
    }

    function obtenerContacto($telf){
        //Devuelve null si no hay un contacto para el telefono buscado
        //Devuelve un objeto contacto si sí hay un contacto para el tlf buscado
        $resultado=null;
        try {
            if(file_exists($this->nombre)){
                $registros = file($this->nombre);
                foreach($registros as $linea){
                    $campos = explode(";",$linea);
                    if($campos[2]==$telf){
                        //He encontrado un contacto para el tlf buscado
                        $resultado = new Contacto($campos[0],$campos[1],
                        $campos[2],$campos[3],$campos[4]);
                        return $resultado;
                    }
                }
            }
        } catch (\Throwable $th) {
            echo 'Error al obtener contacto:'.$th->getMessage();
        }

        return $resultado;
    }
}
?>