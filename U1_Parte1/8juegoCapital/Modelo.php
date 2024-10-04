<?php
require_once 'Pregunta.php';

class Modelo{
    private $nombre='preguntas.txt';

    function __construct()
    {
        
    }
    function obtenerPreguntas(){
        $resultado = array();
        try {
            if(file_exists($this->nombre)){
                $registros=file($this->nombre,FILE_IGNORE_NEW_LINES);
                foreach($registros as $linea){
                    $campos=explode(';',$linea);
                    $resultado[]=new Pregunta($campos[0],$campos[1],$campos[2]);
                }
            }
           
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        return $resultado;
    }
}

?>