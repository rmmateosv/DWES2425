<?php
require_once 'Usuarios.php';
require_once 'Recursos.php';
require_once 'Reservas.php';

$mensaje = '';

class Modelo
{
	private $conexion;


	function __construct()
	{
		try {
			$this->conexion = new PDO(
				'mysql:host=localhost;port=3306;dbname=reservas',
				'root',
				'root'
			);
		} catch (\Throwable $th) {
			// echo $th->getMessage();
			global $mensaje;
			$mensaje = $th->getMessage();
		}
	}

	function obtenerUsuario($usuario, $ps)
	{
		$respuesta = null;
		try {
			$consulta = $this->conexion->prepare('SELECT * FROM usuarios WHERE idrayuela=? 
            and ps=sha2(?,512)');
			$params = [$usuario, $ps];
			if ($consulta->execute($params)) {
				if ($fila = $consulta->fetch()) {
					$respuesta = new Usuarios($fila[0], $fila[1], $fila['activo'], $fila['numReservas']);
				}
			}
		} catch (\Throwable $th) {
			global $mensaje;
			$mensaje = $th->getMessage();
		}

		return $respuesta;
	}

	function obtenerRecursos()
	{
		$respuesta = array();
		try {
			$consulta = $this->conexion->query('SELECT * from recursos');
			while ($fila = $consulta->fetch()) {
				$respuesta[] = new Recursos($fila['id'], $fila['nombre'], $fila['tipo'], $fila['descripcion']);
			}
		} catch (\Throwable $th) {
			global $mensaje;
			$mensaje = $th->getMessage();
		}
		return $respuesta;
	}

	function obtenerReservas($recurso)
	{
		$respuesta = [];
		try {
			$consulta = $this->conexion->prepare('SELECT re.*, u.nombre as nombreU , r.nombre as nombreR from reservas as re
																						join recursos as r on recurso = r.id
																						join usuarios as u on usuario = idRayuela 
																						where  recurso = ? and anulada = false order by fecha desc');
			$params = [$recurso];
			if ($consulta->execute($params)) {
				while ($fila = $consulta->fetch()) {
					$respuesta[] = new Reservas(
						$fila['id'],
						new Usuarios($fila['usuario'],$fila['nombreU'],null,null),
						new Recursos(null,$fila['nombreR'],null,null),
						$fila['fecha'],
						$fila['hora'],
						$fila['anulada']
					);
				}
			}
		} catch (\Throwable $th) {
			global $mensaje;
			$mensaje = $th->getMessage();
		}
		return $respuesta;
	}

	function verificarDisponibilidad($fecha,$recurso,$hora){

		$respuesta=false;

		try {
			$consulta=$this->conexion->prepare('SELECT disponibilidad(?,?,?)');
			$params=array($recurso,$fecha,$hora);

			if($consulta->execute($params)){
				if($fila=$consulta->fetch()){
					
					// seria lo mismo $respuesta=$fila[0];
					return $fila[0];
				}
			}
			
		} catch (\Throwable $th) {
			global $mensaje;
			$mensaje = $th->getMessage();
		}

		return $respuesta;

	}

	function guardarReserva($r){
		$respuesta=false;
		try {
			
			$this->conexion->beginTransaction();
			//Consulta para insertar la reserva
			$consulta=$this->conexion->prepare('INSERT into reservas(recurso,usuario,hora,fecha) values (?,?,?,?)');
			$params=array($r->getRecurso(),$r->getUsuario(),$r->getHora(),$r->getFecha());
			if($consulta->execute($params) and $consulta->rowCount()==1){
				$consulta=$this->conexion->prepare('UPDATE usuarios set numReservas=numReservas + 1 where idRayuela= ?');
				$params=array($r->getUsuario());

				if($consulta->execute($params) and $consulta->rowCount()==1){
					$this->conexion->commit();
					$respuesta=true;

				}else{
					$this->conexion->rollback();
					
				}
	
			}

		} catch (\Throwable $th) {

			$this->conexion->rollback();
			global $mensaje;
			$mensaje = $th->getMessage();
		}

		return $respuesta;

	}

	function infoUsuario($usuario)
	{
		$respuesta = null;
		try {
			$consulta = $this->conexion->prepare('SELECT * FROM usuarios WHERE idrayuela=?');
			$params = [$usuario];
			if ($consulta->execute($params)) {
				if ($fila = $consulta->fetch()) {
					$respuesta = new Usuarios($fila[0], $fila[1], $fila['activo'], $fila['numReservas']);
				}
			}
		} catch (\Throwable $th) {
			global $mensaje;
			$mensaje = $th->getMessage();
		}

		return $respuesta;
	}

	function anularReserva($usuario,$recurso,$fecha,$hora){
		
		$respuesta=false;
		try {
			
			$this->conexion->beginTransaction();
			//Consulta para insertar la reserva
			$consulta=$this->conexion->prepare('UPDATE reservas set anulada=true where usuario=? and recurso=? and fecha=? and hora=?');
			$params=array($usuario,$recurso,$fecha,$hora);

			if($consulta->execute($params) and $consulta->rowCount()==1){
				$consulta=$this->conexion->prepare('UPDATE usuarios set numReservas=numReservas - 1 where idRayuela= ?');
				$params=array($usuario);

				if($consulta->execute($params) and $consulta->rowCount()==1){
					$this->conexion->commit();
					$respuesta=true;

				}else{
					$this->conexion->rollback();
					
				}
	
			}

		} catch (\Throwable $th) {

			$this->conexion->rollback();
			global $mensaje;
			$mensaje = $th->getMessage();
		}

		return $respuesta;

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
