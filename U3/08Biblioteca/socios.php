<?php
require_once 'controlador.php';
if ($_SESSION['usuario']->getTipo() == 'S') {
    //Los socios no pueden acceder a esta página
    header('location:login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>
    <?php
    require_once 'menu.php';
    ?>
    <div class="container">
        <br />
        <div>
            <!-- ÁREA DE ERRORES -->
            <?php
            if (isset($mensaje)) {
                echo '<div class="alert alert-success" role="alert">' . $mensaje . '</div>';
            }
            if (isset($error)) {
                echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
            }
            ?>
        </div>
        <div>
            <!-- ÁREA DE INSERT (SÓLO ADMIN) -->
            <?php
            if ($_SESSION['usuario']->getTipo() == 'A') {
            ?>
                <form action="" method="post">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="dni" class="form-label">DNI</label>
                            <input type="text" class="form-control" name="dni" id="dni" 
                            value="<?php echo (isset($_POST['dni'])?$_POST['dni']:'')?>"/>
                        </div>
                        <div class="col-md-3">
                            <label for="tipo" class="form-label">Tipo</label>
                            <select class="form-select" name="tipo" id="tipo" onchange="submit()">
                                <option value="A">Administrador</option>
                                <option value="S" 
                        <?php echo (isset($_POST['tipo']) && $_POST['tipo']=='S'?'selected="selected"':'')?>
                            >Socio</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Acción</label><br />
                            <button class="btn btn-outline-secondary" type="submit" id="sCrearSocio" name="sCrearSocio">+</button>
                        </div>
                    </div>
                    <?php
                    if(isset($_POST['tipo']) and $_POST['tipo']=='S'){
                    ?>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" />
                        </div>
                        <div class="col-md-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" />
                        </div>
                        
                    </div>
                    <?php
                    }
                    ?>
                </form>
            <?php
            }
            ?>
        </div>
        <div>
            <br />
            <!-- mostrar préstamos -->
            <form action="" method="post">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Tipo</th>
                            <th>IdSocio</th>
                            <th>Nombre</th>
                            <th>Fecha Sanción</th>
                            <th>Email</th>
                            <?php if ($_SESSION['usuario']->getTipo() == 'A') { ?>
                                <th>Acciones</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $datos = $bd->obtenerDatosUsSocios();
                            foreach($datos as $d){
                                $u=$d[0];
                                $s=$d[1];
                                echo '<tr>';
                                echo '<td>'.generarInput('input','dni',$u->getId(),'sMSocio',$u->getId()).'</td>';
                                echo '<td>'.$u->getTipo().'</td>';
                                if($u->getTipo()=='S'){
                                    echo '<td>'.$s->getId().'</td>';
                                    echo '<td>'.generarInput('input','nombre',$s->getNombre(),'sMSocio',$u->getId()).'</td>';
                                    echo '<td>'.
                                    ($s->getFechaSancion()==null?'':generarInput('input type="date"','fSancion',
                                                                                    $s->getFechaSancion(),'sMSocio',$u->getId())).
                                    '</td>';
                                    echo '<td>'.generarInput('input type="email"','email',$s->getEmail(),'sMSocio',$u->getId()).'</td>';
                                }
                                else{
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                }
                                //Obtener si el socio tiene préstamos para generar ventanas de avisos
                                $tienePrestamos=sizeof($bd->obtenerPrestamosSocio($u))>0;
                                echo '<td>'.
                                generarBotones('sMSocio','sGSocio','Modificar','Guardar','sMSocio',$u->getId(),false).                                
                                generarBotones('sBSocio','sCSocio','Borrar','Cancelar','sMSocio',$u->getId(),$tienePrestamos)
                                .'</td>';
                                echo '</tr>';
                            }
                        ?>

                    </tbody>
                </table>
            </form>
        </div>
    </div>
</body>

</html>