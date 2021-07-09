<?php
include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['proveedor']) || empty($_POST['tipodeproveedor'])|| empty($_POST['preciojaba'])) {
        $alert = '<div class="alert alert-danger" role="alert">
                        Todo los campos son obligatorios
                    </div>';
    } else {
        $proveedor = $_POST['proveedor'];
        $tipodeproveedor = $_POST['tipodeproveedor'];
        $preciojaba = $_POST['preciojaba'];
        $usuario_id = $_SESSION['idUser'];
        $query = mysqli_query($conexion, "SELECT * FROM proveedor where tipodeproveedor = '$tipodeproveedor'");
        $result = mysqli_fetch_array($query);

        //if ($result > 0) {
         //   $alert = '<div class="alert alert-danger" role="alert">
           //             El Ruc ya esta registrado
             //       </div>';
        //}else{
        

        $query_insert = mysqli_query($conexion, "INSERT INTO proveedor(proveedor,tipodeproveedor,preciojaba,usuario_id) values ('$proveedor', '$tipodeproveedor','$preciojaba','$usuario_id')");
        if ($query_insert) {
            $alert = '<div class="alert alert-primary" role="alert">
                        Proveedor Registrado
                    </div>';
        } else {
            $alert = '<div class="alert alert-danger" role="alert">
                       Error al registrar proveedor
                    </div>';
        }
        }
    }

mysqli_close($conexion);
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card-header bg-primary text-white">
                Registro de Proveedor
            </div>
            <div class="card">
                <form action="" autocomplete="off" method="post" class="card-body p-2">
                    <?php echo isset($alert) ? $alert : ''; ?>
                    <div class="form-group">
                        <label for="nombre">NOMBRE de proveedor</label>
                        <input type="text" placeholder="Ingrese nombre" name="proveedor" id="nombre" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="proveedor">tipodeproveedor</label>
                        <input type="text" placeholder="Ingrese nombre del contacto" name="tipodeproveedor" id="tipodeproveedor" class="form-control">
                    </div>
                  <div class="form-group">
                        <label for="preciojaba">preciojaba</label>
                        <input type="text" placeholder="Ingrese peso de jaba" name="preciojaba" id="preciojaba" class="form-control">
                    </div>
                    <!--<div class="form-group">
                        <label for="direccion">DIRECIÓN</label>
                        <input type="text" placeholder="Ingrese Direccion" name="direccion" id="direcion" class="form-control">
                    </div>
                    -->
                    <input type="submit" value="Guardar Proveedor" class="btn btn-primary">
                    <a href="lista_proveedor.php" class="btn btn-danger">Regresar</a>
                </form>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>