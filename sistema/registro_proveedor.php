<?php
include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['proveedor']) || empty($_POST['tipoproveedor']) || empty($_POST['preciojaba'])) {
        $alert = '<div class="alert alert-danger" role="alert">
                        Todo los campos son obligatorios
                    </div>';
    } else {
        $proveedor = $_POST['proveedor'];
        $tipoproveedor = $_POST['tipoproveedor'];
        $preciojaba = $_POST['preciojaba'];
        $usuario_id = $_SESSION['idUser'];
        $query = mysqli_query($conexion, "SELECT * FROM proveedor where proveedor = '$proveedor'");
        $result = mysqli_fetch_array($query);
       

        //if ($result > 0) {
         //   $alert = '<div class="alert alert-danger" role="alert">
           //             El Ruc ya esta registrado
             //       </div>';
        //}else{
        

        $query_insert = mysqli_query($conexion, "INSERT INTO proveedor(proveedor,tipoproveedor,preciojaba,usuario_id) values ('$proveedor', '$tipoproveedor','$preciojaba','$usuario_id')");
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
                        <label for="nombre">Nombre  de Proveedor</label>
                        <input type="text" placeholder="Ingrese nombre de Proveedor" name="proveedor" id="nombre" class="form-control">
                    </div>
                    <div class="form-group">
                    <label>Tipo de proveedor</label>
                    <select name="tipoproveedor" id="tipoproveedor" class="form-control">
                        <?php
                        $query_tipoproveedor = mysqli_query($conexion, "select * from tipoproveedor");
                        mysqli_close($conexion);
                        $resultado_tipoproveedor = mysqli_num_rows($query_tipoproveedor);
                        if ($resultado_tipoproveedor > 0) {
                            while ($tipoproveedor = mysqli_fetch_array($query_tipoproveedor)) {
                        ?>
                                <option value="<?php echo $tipoproveedor["idtipoproveedor"]; ?>"><?php echo $tipoproveedor["tipoproveedor"] ?></option>
                        <?php

                            }
                        }

                        ?>
                    </select></div>
                  <div class="form-group">
                        <label for="preciojaba">Peso de Jaba</label>
                        <input type="number" placeholder="Ingrese peso de jaba" name="preciojaba" id="preciojaba" class="form-control" data-field="Amount" min="0.01" step="0.01">
                    </div>
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