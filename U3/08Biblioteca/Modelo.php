<?php
require_once 'Usuario.php';
require_once 'Socio.php';
require_once 'Libro.php';
require_once 'Prestamo.php';

class Modelo
{

    private $conexion = null;

    public function __construct()
    {
        try {
            $config = $this->obtenerDatos();
            if ($config != null) {
                //Establecer conexión con la bd
                $this->conexion = new PDO(
                    'mysql:host=' . $config['urlBD'] .
                        ';port=' . $config['puerto'] . ';dbname=' . $config['nombreBD'],
                    $config['usBD'],
                    $config['psUS']
                );
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    private function obtenerDatos()
    {
        $resultado = array();
        if (file_exists('.config')) {
            $datosF = file('.config', FILE_IGNORE_NEW_LINES);
            foreach ($datosF as $linea) {
                $campos = explode('=', $linea);
                $resultado[$campos[0]] = $campos[1];
            }
        } else {
            return null;
        }
        return $resultado;
    }

    public function loguear($us, $ps)
    {
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
            $params = array($us, $ps);

            //Ejecutar consulta
            if ($consulta->execute($params)) {
                //Recuperar el resultado y transformarlo en un objeto Usuario
                if ($fila = $consulta->fetch()) {
                    $resultado = new Usuario($fila['id'], $fila['tipo']);
                }
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }

        return $resultado;
    }
    function obtenerSocios()
    {
        //Devuleve un array vacío si no hay socios
        //Si hay socios devuelve un array con objetos Socio
        $resultado = array();
        try {
            $textoConsulta = 'SELECT * from socios  order by nombre';
            //Ejecutar consulta
            $c = $this->conexion->query($textoConsulta);
            if ($c) {
                //Acceder al resultado de la consulta
                while ($fila = $c->fetch()) {
                    $resultado[] = new Socio(
                        $fila['id'],
                        $fila['nombre'],
                        $fila['fechaSancion'],
                        $fila['email'],
                        $fila['us']
                    );
                }
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        return $resultado;
    }

    function obtenerLibros()
    {
        //Devuleve un array vacío si no hay liros
        //Si hay libros devuelve un array con objetos Libro
        $resultado = array();
        try {
            $textoConsulta = 'SELECT * from libros  order by titulo';
            //Ejecutar consulta
            $c = $this->conexion->query($textoConsulta);
            if ($c) {
                //Acceder al resultado de la consulta
                while ($fila = $c->fetch()) {
                    $resultado[] = new Libro(
                        $fila['id'],
                        $fila['titulo'],
                        $fila['ejemplares'],
                        $fila['autor']
                    );
                }
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        return $resultado;
    }

    public function comprobar($socio, $libro)
    {
        $resultado = 'ok';
        try {
            //llamar función de la bd comprobarSiPrestar(pSocio int, pLibro int)
            $consulta = $this->conexion->prepare('SELECT comprobarSiPrestar(?,?)');
            $params = array($socio, $libro);
            if ($consulta->execute($params)) {
                if ($fila = $consulta->fetch()) {
                    $codigo = $fila[0];
                    switch ($codigo) {
                        case -1:
                            $resultado = 'No hay ejemplares del libro o el libro no existe';
                            break;
                        case -2:
                            $resultado = 'El socio está sancionado o el socio no existe';
                            break;
                        case -3:
                            $resultado = 'El socio tiene préstamos caducados';
                            break;
                        case -4:
                            $resultado = 'El socio tiene más de 2 libros prestados';
                            break;
                    }
                }
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        return $resultado;
    }

    public function crearPrestamo($idSocio, $idLibro)
    {
        $resultado = 0;
        try {
            //Iniciamos transacción ya que vamos a hacer un
            //Insert y un update
            $this->conexion->beginTransaction();
            //Insert
            $consulta = $this->conexion->prepare('INSERT into prestamos values
                (null,?,?,curdate(), adddate(curdate(), INTERVAL 30  DAY ), null)');
            $params = array($idSocio, $idLibro);
            if ($consulta->execute($params)) {
                //Comprobamos si se ha insertado 1 fila
                if ($consulta->rowCount() == 1) {
                    //Obtenemos el id del préstamos creado
                    $id = $this->conexion->lastInsertId();
                    //Update
                    $consulta = $this->conexion->prepare('UPDATE libros 
                        set ejemplares=ejemplares-1 where id = ?');
                    $params = array($idLibro);
                    if ($consulta->execute($params) and $consulta->rowCount() == 1) {
                        $this->conexion->commit();
                        $resultado = $id;
                    } else {
                        $this->conexion->rollBack(); //Deshacemos Insert
                    }
                }
            }
        } catch (PDOException $e) {
            $this->conexion->rollBack();
            echo $e->getMessage();
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        return $resultado;
    }

    public function obtenerPrestamos()
    {
        $resultado = array();
        try {
            $consulta = $this->conexion->query('SELECT * from prestamos as p
                inner join socios as s on p.socio=s.id 
                inner join libros as l on p.libro=l.id 
                order by p.fechaD desc,  p.id');
            if ($consulta) {
                while ($fila = $consulta->fetch()) {
                    //Creamos objeto préstamo, el socio y el libro son OBJETOS
                    $p = new Prestamo(
                        $fila[0],
                        new Socio(
                            $fila['socio'],
                            $fila['nombre'],
                            $fila['fechaSancion'],
                            $fila['email'],
                            $fila['us']
                        ),
                        new Libro(
                            $fila['libro'],
                            $fila['titulo'],
                            $fila['ejemplares'],
                            $fila['autor']
                        ),
                        $fila['fechaP'],
                        $fila['fechaD'],
                        $fila['fechaRD']
                    );
                    //Añadimos el préstamo a resultado
                    $resultado[] = $p;
                }
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        return $resultado;
    }
    function obtenerPrestamo($id)
    {
        $resultado = null;
        try {
            $consulta = $this->conexion->prepare('SELECT * from prestamos as p 
                                                    inner join socios as s on p.socio = s.id 
                                                    inner join libros as l on p.libro = l.id 
                                                    where p.id = ?');
            $params = array($id);
            if ($consulta->execute($params)) {
                if ($fila = $consulta->fetch()) {
                    $resultado = new Prestamo(
                        $fila[0],
                        new Socio($fila['socio'], $fila['nombre'], $fila['fechaSancion'], $fila['email'], $fila['us']),
                        new Libro($fila['libro'], $fila['titulo'], $fila['ejemplares'], $fila['autor']),
                        $fila['fechaP'],
                        $fila['fechaD'],
                        $fila['fechaRD']
                    );
                }
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        return $resultado;
    }

    function devolverPrestamo($p, $sancionar)
    {
        $resultado = false;
        try {
            //Iniciamos transacción
            $this->conexion->beginTransaction();
            //Devolver Préstamo
            $consulta = $this->conexion->prepare('UPDATE prestamos set fechaRD=curdate() 
                                                    where id=?');
            $params = array($p->getId());
            if ($consulta->execute($params) and $consulta->rowCount() == 1) {
                //Actualizar ejemplares del libro
                $consulta = $this->conexion->prepare('UPDATE libros set ejemplares=ejemplares+1 
                                                        where id=?');
                $params = array($p->getLibro()->getId());
                if ($consulta->execute($params) and $consulta->rowCount() == 1) {
                    //Sancionar socio si es necesario
                    if ($sancionar) {
                        $consulta = $this->conexion->prepare('UPDATE socios set 
                                                            fechaSancion=adddate(curdate(),interval 1 month)
                                                        where id=?');
                        $params = array($p->getSocio()->getId());
                        if ($consulta->execute($params) and $consulta->rowCount() == 1) {
                            $this->conexion->commit();
                            $resultado = true;
                        } else {
                            $this->conexion->rollBack();
                        }
                    } else {
                        $this->conexion->commit();
                        $resultado = true;
                    }
                } else {
                    $this->conexion->rollBack();
                }
            }
        } catch (PDOException $th) {
            //throw $th;
            $this->conexion->rollBack();
            echo $th->getMessage();
        } catch (\Throwable $th) {
            //throw $th;
            echo $th->getMessage();
        }
        return $resultado;
    }
    function obtenerPrestamosSocio($us)
    {
        $resultado = array();
        try {
            //Seleccionamos los préstamos de un socio
            $consulta = $this->conexion->prepare('SELECT * from prestamos as p
                            inner join socios as s on p.socio=s.id 
                            inner join libros as l on p.libro=l.id 
                             where s.us = ?');
            $params = array($us->getId());
            if ($consulta->execute($params)) {
                while ($fila = $consulta->fetch()) {
                    $resultado[] = new Prestamo(
                        $fila[0],
                        new Socio($fila['socio'], $fila['nombre'], $fila['fechaSancion'], $fila['email'], $fila['us']),
                        new Libro($fila['libro'], $fila['titulo'], $fila['ejemplares'], $fila['autor']),
                        $fila['fechaP'],
                        $fila['fechaD'],
                        $fila['fechaRD']
                    );
                }
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        return $resultado;
    }
    public function crearLibro($l)
    {
        $resultado = 0;
        try {
            $consulta = $this->conexion->prepare('INSERT into libros values
                (null,?,?,?)');
            $params = array($l->getTitulo(), $l->getEjemplares(), $l->getAutor());
            if ($consulta->execute($params)) {
                //Comprobamos si se ha insertado 1 fila
                if ($consulta->rowCount() == 1) {
                    //Obtenemos el id del préstamos creado
                    $resultado = $this->conexion->lastInsertId();
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        return $resultado;
    }
    function obtenerUsuarioDni($dni)
    {
        $resultado = null;
        try {
            $consulta = $this->conexion->prepare('SELECT * from usuarios where upper(id) = upper(?)');
            $params = array($dni);
            if ($consulta->execute($params)) {
                if ($fila = $consulta->fetch()) {
                    $resultado = new Usuario($fila['id'], $fila['tipo']);
                }
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }

        return $resultado;
    }

    public function crearUsuario($u, $s)
    {
        $resultado = false;
        try {
            $this->conexion->beginTransaction();
            //Crear usuario
            $consulta = $this->conexion->prepare('INSERT into usuarios values (?,sha2(?,512),?)');
            $params = array($u->getId(), $u->getId(), $u->getTipo());
            if ($consulta->execute($params) and $consulta->rowCount() == 1) {
                //Comprobar si crear socio
                if ($s != null) {
                    //Crear Socio
                    $consulta = $this->conexion->prepare('INSERT into socios values (null,?,null,?,?)');
                    $params = array($s->getNombre(), $s->getEmail(), $s->getUs());
                    if ($consulta->execute($params) and $consulta->rowCount() == 1) {
                        $this->conexion->commit();
                        $resultado = true;
                    } else {
                        $this->conexion->rollBack();
                    }
                } else {
                    $this->conexion->commit();
                    $resultado = true;
                }
            }
        } catch (\PDOException $e) {
            $this->conexion->rollBack();
            echo $e->getMessage();
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        return $resultado;
    }
    public function obtenerDatosUsSocios()
    {
        $resultado = array();

        try {
            $consulta = $this->conexion->query('SELECT * from usuarios as u left outer join socios as s 
                                                on u.id = s.us  order by u.tipo, u.id');

            while ($fila = $consulta->fetch()) {
                $resultado[] = array(
                    new Usuario($fila[0], $fila['tipo']),
                    new Socio($fila[3], $fila['nombre'], $fila['fechaSancion'], $fila['email'], $fila['us'])
                );
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        return $resultado;
    }

    function obtenerSocioDni($dni)
    {
        $resultado = null;
        try {
            $consulta = $this->conexion->prepare('SELECT * from socios where upper(us) = upper(?)');
            $params = array($dni);
            if ($consulta->execute($params)) {
                if ($fila = $consulta->fetch()) {
                    $resultado = new Socio(
                        $fila['id'],
                        $fila['nombre'],
                        $fila['fechaSancion'],
                        $fila['email'],
                        $fila['us']
                    );
                }
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }

        return $resultado;
    }
    function modificarUSySocio($u, $s, $dniAntiguo)
    {
        $resultado = false;
        try {
            $this->conexion->beginTransaction();
            //Modficar usuario
            $consulta = $this->conexion->prepare('UPDATE usuarios set id = ? where id = ?');
            $params = array($u->getId(), $dniAntiguo);
            if ($consulta->execute($params)) {
                //Comprobar si crear socio
                if ($s != null) {
                    //Modificar Socio
                    $consulta = $this->conexion->prepare('UPDATE socios set nombre = ?, fechaSancion=?, email=? 
                                where id = ?');
                    $params = array($s->getNombre(), $s->getFechaSancion(), $s->getEmail(), $s->getId());
                    if ($consulta->execute($params)) {
                        $this->conexion->commit();
                        $resultado = true;
                    } else {
                        $this->conexion->rollBack();
                    }
                } else {
                    $this->conexion->commit();
                    $resultado = true;
                }
            }
        } catch (\PDOException $e) {
            $this->conexion->rollBack();
            echo $e->getMessage();
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        return $resultado;
    }

    function borrarUsuario($u, $borrarPrestamos)
    {
        $resultado = false;

        try {
            $this->conexion->beginTransaction();
            if ($borrarPrestamos) {
                $consulta = $this->conexion->prepare('DELETE from prestamos where socio = 
                    (SELECT id from socios where us = ?)');
                $params = array($u->getId());
                if (!$consulta->execute($params)) {
                    return false;
                }
            }
            //Borrar Socio
            $consulta = $this->conexion->prepare('DELETE from socios where us = ?');
            $params = array($u->getId());
            if ($consulta->execute($params)) {
                //Borrar usuario
                $consulta = $this->conexion->prepare('DELETE from usuarios where id = ?');
                $params = array($u->getId());
                if ($consulta->execute($params) and $consulta->rowCount() == 1) {
                    $this->conexion->commit();
                    $resultado = true;
                } else {
                    $this->conexion->rollBack();
                }
            } else {
                $this->conexion->rollBack();
            }
        } catch (PDOException $th) {
            //throw $th;
            $this->conexion->rollBack();
            echo $th->getMessage();
        } catch (\Throwable $th) {
            //throw $th;
            echo $th->getMessage();
        }

        return $resultado;
    }
    function borrarLibro($l)
    {
        $resultado = false;
        try {
            $consulta = $this->conexion->prepare('DELETE from libros where id = ?');
            $params = array($l->getId());
            if ($consulta->execute($params) and $consulta->rowCount() == 1) {
                $resultado = true;
            }
        } catch (PDOException $th) {
            //throw $th;
            echo $th->getMessage();
        } catch (\Throwable $th) {
            //throw $th;
            echo $th->getMessage();
        }
        return $resultado;
    }
    public function obtenerLibro($id){
        $resultado = null;
        try {
            $consulta = $this->conexion->prepare('SELECT * from libros where id = ?');
            $params = array($id);
            if ($consulta->execute($params)) {
                if ($fila = $consulta->fetch()) {
                    $resultado = new Libro(
                        $fila['id'],
                        $fila['titulo'],
                        $fila['ejemplares'],
                        $fila['autor']
                    );
                }
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }

        return $resultado;
    }
    public function obtenerPrestamosLibro($id){
        $resultado = array();
        try {
            //Seleccionamos los préstamos de un socio
            $consulta = $this->conexion->prepare('SELECT * from prestamos as p
                            inner join socios as s on p.socio=s.id 
                            inner join libros as l on p.libro=l.id 
                             where l.id = ?');
            $params = array($id);
            if ($consulta->execute($params)) {
                while ($fila = $consulta->fetch()) {
                    $resultado[] = new Prestamo(
                        $fila[0],
                        new Socio($fila['socio'], $fila['nombre'], $fila['fechaSancion'], $fila['email'], $fila['us']),
                        new Libro($fila['libro'], $fila['titulo'], $fila['ejemplares'], $fila['autor']),
                        $fila['fechaP'],
                        $fila['fechaD'],
                        $fila['fechaRD']
                    );
                }
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        return $resultado;
    }
    public function estadistica($idS){
        $resultado=array();
        try {
            //code...
            $consulta = $this->conexion->prepare('CALL infoSocio(?)');
            $params=array($idS);
            if($consulta->execute($params)){
                //Tratamos el primer select del procedimiento
                if($fila=$consulta->fetch()){
                    $resultado[]=array(1,'Total Préstamos',$fila[0]);
                    $resultado[]=array(1,'Primer Préstamo',$fila[1]);
                    $resultado[]=array(1,'Último Préstamo',$fila[2]);
                }
                //TRatar los datos del seguno select del procedimineto
                if($consulta->nextRowset()){
                    if($fila=$consulta->fetch()){
                        $resultado[]=array(1,'No Devueltos',$fila[0]);
                        $resultado[]=array(1,'Devueltos',$fila[1]);
                        $resultado[]=array(1,'Último Libro',$fila[2]);
                    }
                }
                //TRatar los datos del último select del procedimineto
                if($consulta->nextRowset()){
                    while($fila=$consulta->fetch()){
                        $resultado[]=array(2,$fila[0],$fila[1]);
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
