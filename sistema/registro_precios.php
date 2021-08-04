<?php include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['proveedor']) || empty($_POST['precioCompra']) || empty($_POST['precioVenta']) || empty($_POST['subidaInterna']) ||  empty($_POST['fechavalida'])) {
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
    $PrecioVentaF = $SubidaInterna + $PrecioVenta;
    $fechavalida = $_POST['fechavalida'];

    $query_insert = mysqli_query($conexion, "INSERT INTO precio(codproveedor,preciocompra,PrecioVenta,SubidaInterna,PrecioVentaF,fechavalidacion) values ('$codproveedor', '$preciocompra', '$PrecioVenta', '$SubidaInterna','$PrecioVentaF','$fechavalida')");
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
<div id="modalAgregarprecio" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content" class="align-items-center">



      <!-- Content Row -->
      <div class="modal-body">

        <div class="box-body">
          <div class="card-header bg-primary text-white">
            Agregar Precio diario
          </div>
          <div class="card-body">
            <form action="" method="post">
              <?php echo isset($alert) ? $alert : ''; ?>
              <div class="form-group">
                <label for="nombre">Proveedor</label>
                <?php $query_proveedor = mysqli_query($conexion, "SELECT * FROM proveedor where estado='A' ORDER BY proveedor ASC");
                $resultado_proveedor = mysqli_num_rows($query_proveedor);
                mysqli_close($conexion);
                ?>
                <select id="proveedor" name="proveedor" class="form-control">
                  
                  <?php
                  if ($resultado_proveedor > 0) {
                    while ($proveedor = mysqli_fetch_array($query_proveedor)) {
                      // code...
                  ?>
                      <option value="<?php echo $proveedor['codproveedor']; ?>"><?php echo $proveedor['proveedor']; ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
          
            <label for="fechavalida">Fecha valida de precio</label>
            <input type="text" placeholder="Ingrese la fecha en la que el precio es valido" class="form-control datepicker" name="fechavalida" id="fechavalida" required>
            
          </div>
              <div class="form-group">
                <label for="preciocompra">Precio de compra</label>
                <input type="decimal" placeholder="Ingrese el precio compra" name="precioCompra" id="precioCompra" class="form-control" >

              </div>
              <div class="form-group">
                <label for="precioVenta">Precio de venta </label>
                <input type="decimal" placeholder="Ingrese el precio precioVenta" class="form-control" name="precioVenta" id="precioVenta" >
              </div>


              <div class="form-group">
                <label for="SubidaInterna">Subida Interna</label>
                <input type="decimal" placeholder="Ingrese el precio de Subida Interna" class="form-control" name="subidaInterna" id="subidaInterna">
              </div>
              <input type="submit" value="Guardar" class="btn col-lg-5 btn-primary">
              <a href="lista_precios.php" class="btn col-lg-5 btn-danger" align="center">Regresar</a>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>