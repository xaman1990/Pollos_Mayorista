<?php include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['nombre']) ) {
        $alert = '<div class="alert alert-danger" role="alert">
                                    El nombre es obligatorio
                                </div>';
    } else {
        $puntos = $_POST['puntos'];
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $preciodejaba = $_POST['preciodejaba'];
        $usuario_id = $_SESSION['idUser'];

        $result = 0;
        if ( $nombre != '') {
            $query = mysqli_query($conexion, "SELECT * FROM cliente where Nombre = '$nombre' and estado='A'");
            $result = mysqli_fetch_array($query);
        }
        if ($result > 0) {
           $alert = '<div class="alert alert-danger" role="alert">
                                   El Nombre ya existe
                              </div>';
        } else {
            $query_insert = mysqli_query($conexion, "INSERT INTO cliente(puntos,nombre,telefono,direccion,preciodejaba, usuario_id) values ('$puntos', '$nombre', '$telefono', '$direccion','$preciodejaba', '$usuario_id')");
            if ($query_insert) {
                $alert = '<div class="alert alert-primary" role="alert">
                                    Cliente Registrado
                                </div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
                                    Error al Guardar
                            </div>';
            }
        }
    }
    mysqli_close($conexion);
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Registro Cliente</h1>
        <a href="lista_cliente.php" class="btn btn-primary">Regresar</a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-6 m-auto">
            <form action="" method="post" autocomplete="off">
                <?php echo isset($alert) ? $alert : ''; ?>
                <div class="form-group">
                    <label for="nombre">Nombre del Cliente</label>
                    <input type="text" placeholder="Ingrese nombre de cliente" name="nombre" id="nombre" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="direccion">Direccion</label>
                    <input type="text" placeholder="Ingrese direccion de cliente" name="direccion" id="direccion" class="form-control">
                </div>
                <div class="form-group">
                    <label for="telefono">Telefono</label>
                    <input type="number" placeholder="Ingrese telefono de cliente" name="telefono" id="telefono" class="form-control">
                </div>
                <div class="form-group">
                    <label for="puntos">Puntos</label>
                    <input type="number" placeholder="Ingrese puntos de cliente" name="puntos" id="puntos" class="form-control" data-field="Amount" min="0.0" step="0.1" >
                </div>
                <div class="form-group">
                    <label for="preciodejaba">Precio de la jaba</label>
                    <input type="number" placeholder="Ingrese precio de jaba" name="preciodejaba" id="preciodejaba" class="form-control"  data-field="Amount" min="0.0" step="0.1" >
                </div>
                <input type="submit" value="Guardar Cliente" class="btn btn-primary">
            </form>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>