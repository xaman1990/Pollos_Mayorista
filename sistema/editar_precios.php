<?php
include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";

  if (empty($_POST['proveedor']) || empty($_POST['precioCompra']) || empty($_POST['precioVenta']) || empty($_POST['subidaInterna']) ) {
    $alert = '<div class="alert alert-danger" role="alert">
              Todo los campos son obligatorios
            </div>';
  } else {
    $idprecio = $_GET['id'];
    $codproveedor = $_POST['proveedor'];
    $preciocompra = $_POST['precioCompra'];
    $PrecioVenta = $_POST['precioVenta'];
    $SubidaInterna = $_POST['subidaInterna'];
    $PrecioVentaF = $SubidaInterna+$PrecioVenta;
    
    $query_update = mysqli_query($conexion, "UPDATE precio SET codproveedor = '$codproveedor', preciocompra= $preciocompra,PrecioVenta= $PrecioVenta ,SubidaInterna=$SubidaInterna,PrecioVentaF=$SubidaInterna+$PrecioVenta WHERE idprecio = $idprecio");
    if ($query_update) {
      $alert = '<div class="alert alert-primary" role="alert">
              Modificado
            </div>';
    } else {
      $alert = '<div class="alert alert-primary" role="alert">
                Error al Modificar
              </div>';
    }
  }
  
}

// Validar producto

if (empty($_REQUEST['id'])) {
  header("Location: lista_precio.php");
} else {
  $idprecio = $_REQUEST['id'];
  if (!is_numeric($idprecio)) {
    header("Location: lista_precio.php");
  }
  $query_precio = mysqli_query($conexion, "SELECT r.idprecio,  p.codproveedor , p.proveedor , r.preciocompra , r.precioVenta , r.SubidaInterna , r.PrecioVentaF , r.FechaCreacion , r.Estado FROM proveedor p INNER JOIN precio r ON p.codproveedor= r.codproveedor WHERE idprecio = $idprecio ");
  $result_precio = mysqli_num_rows($query_precio);

  if ($result_precio > 0) {
    $data_precio = mysqli_fetch_assoc($query_precio);
  } else {
    header("Location: lista_precio.php");
  }
}
?>
<!-- Begin Page Content -->
<div class="container-fluid">
<a href="lista_precios.php" class="btn btn-primary">Regresar</a>

  <div class="row">
    <div class="col-lg-6 m-auto">
      <div class="card">
        <div class="card-header bg-primary text-white">
          Modificar precio
        </div>
        <div class="card-body">
          <form action="" method="post">
            <?php echo isset($alert) ? $alert : ''; ?>
            <div class="form-group">
              <label for="nombre">Proveedor</label>
              <?php $query_proveedor = mysqli_query($conexion, "SELECT * FROM proveedor ORDER BY proveedor ASC");
              $resultado_proveedor = mysqli_num_rows($query_proveedor);
              mysqli_close($conexion);
              ?>
              <select id="proveedor" name="proveedor" class="form-control">   
                <option value="<?php echo $data_precio['codproveedor']; ?>" selected><?php echo $data_precio['proveedor']; ?></option>
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
              <label for="preciocompra">Precio de compra</label>                                                                                 
              <input type="number" placeholder="Ingrese el precio compra" name="precioCompra" id="precioCompra" class="form-control" value="<?php echo $data_precio['preciocompra']; ?>">
            
            </div>
            <div class="form-group">
              <label for="precioVenta">Precio de venta </label>
              <input type="number" placeholder="Ingrese el precio precioVenta" class="form-control" name="precioVenta" id="precioVenta" value="<?php echo $data_precio['precioVenta']; ?>">
            </div>

        
            <div class="form-group">
              <label for="SubidaInterna">Subida Interna</label>
              <input type="number" placeholder="Ingrese el precio de Subida Interna" class="form-control" name="subidaInterna" id="subidaInterna" value="<?php echo $data_precio['SubidaInterna']; ?>">
            </div>
            <input type="submit" value="Actualizar Precio" class="btn btn-primary">
          </form>
        </div>
      </div>
    </div>
  </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>