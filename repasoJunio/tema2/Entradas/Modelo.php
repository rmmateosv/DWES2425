<?php
require_once "Entrada.php";

class Modelo{
    private $fichero='entradas.txt';

    function insertar(Entrada $e){
        try {
            $f = fopen($this->fichero, 'a');
            fwrite($f, $e->getNombreCliente().';');
            fwrite($f, $e->getTipoEntrada().';');
            fwrite($f, $e->getFechaEvento().';');
            fwrite($f, $e->getNEntradas().';');
            fwrite($f, $e->getDescuentos().';');
            fwrite($f, $e->getImporte().PHP_EOL);
            fclose($f);

            return true;

        } catch (\Throwable $th) {
            echo 'Error al guardar la entrada:'.$th->getMessage();
        }

        return false;
    }

    function cargarEntradas(){
        $resultado = array();

            if (file_exists($this->fichero)) {
                $tmp = file($this->fichero,FILE_IGNORE_NEW_LINES);
                foreach ($tmp as $t) {
                    $datos = explode(';',$t);
                    $entrada = new Entrada($datos[0],$datos[1],$datos[2],$datos[3],$datos[4],$datos[5]);
                    $resultado[]= $entrada;
                }

            }
        return $resultado;

    }

}
?>