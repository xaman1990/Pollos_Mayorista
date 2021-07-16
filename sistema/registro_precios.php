<?php include_once "includes/header.php";
  include "../conexion.php";
  if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['proveedor']) || empty($_POST['precioCompra']) || empty($_POST['precioVenta']) || empty($_POST['subidaInterna']) ||  empty($_POST['fechavalidacion'])  ) {
      echo '<script>
        Swal.fire({
              type: "error",
              title: "¡Todos los campos son obligatorios!",
              showConfirmButton: true,
              confirmButtonText: "Cerrar"
              }).then(function(result){
                if (result.value) {
                window.location = "lista_precios.php";
                }
            })
      </script>';
    } else {
     
      $codproveedor = $_POST['proveedor'];
      $preciocompra = $_POST['precioCompra'];
      $PrecioVenta = $_POST['precioVenta'];
      $SubidaInterna = $_POST['subidaInterna'];
      $PrecioVentaF = $SubidaInterna+$PrecioVenta;
      $fechavalidacion = $_POST['fechavalidacion'];

      $query_insert = mysqli_query($conexion, "INSERT INTO precio(codproveedor,preciocompra,PrecioVenta,SubidaInterna,PrecioVentaF,fechavalidacion) values ('$codproveedor', '$preciocompra', '$PrecioVenta', '$SubidaInterna','$PrecioVentaF','$fechavalidacion')");
      if ($query_insert) {
           echo '<script>
            Swal.fire({
              type: "success",
              title: "¡El precio fue creado!",
              showConfirmButton: true,
              confirmButtonText: "Cerrar"
              }).then(function(result){
                if (result.value) {
                window.location = "lista_precios.php";
                }
            })
      </script>';
        } else {
            echo '<script>
            Swal.fire({
              type: "error",
              title: "¡Error al crear al precio!",
              showConfirmButton: true,
              confirmButtonText: "Cerrar"
              }).then(function(result){
                if (result.value) {
                window.location = "lista_precios.php";
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
                            Registro de Precio
                        </div>
                        <div class="card">
                            <form action="" autocomplete="off" method="post" class="card-body p-2">
                                <?php echo isset($alert) ? $alert : ''; ?>
                                <div class="form-group">
                                    <label for="nombre">Nombre de Proveedor</label>
                                    <input type="text" placeholder="Ingrese nombre de Proveedor" name="proveedor" id="nombre" class="form-control" required>
                                </div>
                                <div class="form-group ">
                                    <label>Tipo de proveedor</label>
                                    <select name="tipoproveedor" id="tipoproveedor" class="form-control" required>
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
                                    <input type="number" placeholder="Ingrese peso de jaba" name="preciojaba" id="preciojaba" class="form-control" data-field="Amount" min="0.01" step="0.01" required>
                                </div>

                                <div class="modal-footer col-lg-12" >
                                    <input type="submit" value="Guardar" class="btn col-lg-5 btn-primary" align="center">
                                    <a href="lista_precios.php" class="btn col-lg-5 btn-danger" align="center">Regresar</a>
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