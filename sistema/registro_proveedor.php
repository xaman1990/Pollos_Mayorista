<?php
include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['proveedor']) || empty($_POST['tipoproveedor']) || empty($_POST['preciojaba'])) {
        echo '<script>
        Swal.fire({
              type: "error",
              title: "¡Todos los campos son obligatorios!",
              showConfirmButton: true,
              confirmButtonText: "Cerrar"
              }).then(function(result){
                if (result.value) {
                window.location = "lista_proveedor.php";
                }
            })
      </script>';
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
            echo '<script>
            Swal.fire({
              type: "success",
              title: "¡El Proveedor fue creado!",
              showConfirmButton: true,
              confirmButtonText: "Cerrar"
              }).then(function(result){
                if (result.value) {
                window.location = "lista_proveedor.php";
                }
            })
      </script>';
        } else {
            echo '<script>
            Swal.fire({
              type: "error",
              title: "¡Error al crear al proveedor!",
              showConfirmButton: true,
              confirmButtonText: "Cerrar"
              }).then(function(result){
                if (result.value) {
                window.location = "lista_proveedor.php";
                }
            })
      </script>';
        }
    }
}

?>

<!-- Begin Page Content -->
<div id="modalAgregarProveedor" class="modal fade" role="dialog">

    <div class="modal-dialog">

        <div class="modal-content" class="align-items-center">

           

                <!-- Content Row -->
                <div class="modal-body">

                    <div class="box-body">
                        <div class="card-header bg-primary text-white">
                            Registro de Proveedor
                        </div>
                        <div class="card">
                            <form action="" autocomplete="off" method="post" class="card-body p-2">
                                <?php echo isset($alert) ? $alert : ''; ?>
                                <div class="form-group">
                                    <label for="nombre">Nombre de Proveedor</label>
                                    <input type="text" placeholder="Ingrese nombre de Proveedor" name="proveedor" id="nombre" class="form-control">
                                </div>
                                <div class="form-group ">
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
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="preciojaba">Peso de Jaba</label>
                                    <input type="number" placeholder="Ingrese peso de jaba" name="preciojaba" id="preciojaba" class="form-control" data-field="Amount" min="0.01" step="0.01">
                                </div>

                                <div class="modal-footer col-lg-12" >
                                    <input type="submit" value="Guardar" class="btn col-lg-5 btn-primary" align="center">
                                    <a href="lista_proveedor.php" class="btn col-lg-5 btn-danger" align="center">Regresar</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>