<?php
//Incluir librería PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once './vendor/autoload.php';

class Correo
{
    private $ca=null;
    
    function __construct()
    {
        //Cargar la contraseña de aplicación
        $this->ca=$this->obtenerCA();
    }
    private function obtenerCA(){
        $resultado = null;
        try {
            if(file_exists('.config')){
                $contenido = file('.config',FILE_IGNORE_NEW_LINES);
                foreach($contenido as $c){
                    $datos=explode('=',$c);
                    if(isset($datos[0]) and $datos[0]=='ca'){
                        return $datos[1];
                    }
                }
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        return $resultado;
    }
    function enviarCorreo($asunto,$destinatario, $textoHtml,$textoNoHtml)
    {
        $resultado = false;
        try {
            $correo = new PHPMailer(true);
            //Confirgurar datos del servidor saliente
            $correo->isSMTP();
            $correo->Host = 'smtp.gmail.com';
            $correo->SMTPAuth = true;
            $correo->Username = 'rmmateosv@gmail.com';
            $correo->Password = $this->ca;
            $correo->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $correo->Port = 465;
            //Configuración del correo que vamos a escribir
            $correo->setFrom('rmmateosv@gmail.com', 'Bibiloteca de Rosa');
            $correo->addAddress($destinatario->getEmail(), $destinatario->getNombre());
            //Configuración del contenido del mensaje
            $correo->isHTML(true);
            $correo->CharSet = 'UTF-8';
            $correo->Subject = $asunto;
            $texto = $textoHtml;
            $correo->Body = $texto;
            $correo->AltBody = $textoNoHtml;
            //Enviar correo
            if ($correo->send()) {
                $resultado = true;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }

    /**
     * Get the value of ca
     */ 
    public function getCa()
    {
        return $this->ca;
    }

    /**
     * Set the value of ca
     *
     * @return  self
     */ 
    public function setCa($ca)
    {
        $this->ca = $ca;

        return $this;
    }
}
