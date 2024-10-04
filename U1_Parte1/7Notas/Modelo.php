<?php
require_once 'Nota.php';

class Modelo{
    private $nombreFN='notas.dat', $nombreFA='asig.dat';

    function __construct()
    {
        
    }
    function crearNota(Nota $n){
        try{
            $f = fopen($this->nombreFN,'a+');
            fwrite($f,$n->getAsi().';'.date('Y/m/d',strtotime($n->getFecha())).';'.$n->getTipo().';'
            .$n->getDesc().';'.$n->getNota().PHP_EOL);
        }
        catch(Throwable $t){
            echo $t->getMessage();
        }
        finally{
            fclose($f);
        }
    }
    function obtenerNotas(){
        $resultado = array();
        try {
            if(file_exists($this->nombreFN)){
                $registros=file($this->nombreFN);
                foreach($registros as $linea){
                    $campos=explode(';',$linea);
                    $resultado[]=new Nota($campos[0],$campos[1],
                    $campos[2], $campos[3],$campos[4]);
                }
            }
           
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        return $resultado;
    }
    function obtenerAsignaturas(){
        $resultado = array();
        try {
            if(file_exists($this->nombreFA)){
                return file($this->nombreFA);
            }
           
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        return $resultado;
    }
}
?>