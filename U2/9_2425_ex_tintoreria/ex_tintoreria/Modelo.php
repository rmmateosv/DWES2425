<?php
require_once 'Trabajo.php';
class Modelo{
    private $nombreF='trabajos.txt';

    function __construct()
    {
        
    }

    function guardarTrabajo($t){
        $resultado =false;

        $f = fopen($this->nombreF,'a+');
        if($f){
            fwrite($f,date('d/m/Y',strtotime($t->getFecha()))
            .';'.$t->getCliente()
            .';'.$t->getTipo()
            .';'.$t->getServicios()
            .';'.$t->getImporte().PHP_EOL);
            $resultado=true;
        }
        return $resultado;
    }
    function obtenerTrabajos(){
        $resultado=array();
        if(file_exists($this->nombreF)){
            $trabajos = file($this->nombreF,FILE_IGNORE_NEW_LINES);
            foreach($trabajos as $t){
                $fila = explode(';',$t);
                $resultado[]=new Trabajo($fila[0],$fila[1],$fila[2],$fila[3],$fila[4]);
            }
        }
        return $resultado;
    }
}
?>