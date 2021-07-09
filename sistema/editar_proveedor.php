<?php
include "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['proveedor']) || empty($_POST['tipodeproveedor'])|| empty($_POST['preciojaba']))  {
    $alert = '<p class"msg_error">Todo los campos son requeridos</p>';
  } else {
    $idproveedor = $_GET['id'];
    $proveedor = $_POST['proveedor'];
    $tipodeproveedor = $_POST['tipodeproveedor'];
    $preciojaba = $_POST['preciojaba'];

    $sql_update = mysqli_query($conexion, "UPDATE proveedor SET proveedor = '$proveedor', tipodeproveedor = '$tipodeproveedor', preciojaba='$preciojaba' WHERE codproveedor = $idproveedor");

    if ($sql_update) {
      $alert = '<p class"msg_save">Proveedor Actualizado correctamente</p>';
    } else {
      $alert = '<p class"msg_error">Error al Actualizar el Proveedor</p>';
    }
  }
}
// Mostrar Datos

if (empty($_REQUEST['id'])) {
  header("Location: lista_proveedor.php");
  mysqli_close($conexion);
}
$idproveedor = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM proveedor WHERE codproveedor = $idproveedor");
mysqli_close($conexion);
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
  header("Location: lista_proveedor.php");
} else {
  while ($data = mysqli_fetch_array($sql)) {
    $idproveedor = $data['codproveedor'];
    $proveedor = $data['proveedor'];
    $tipodeproveedor = $data['tipodeproveedor'];
    $preciojaba = $data['preciojaba'];
  }
}
?>
<!-- Begin Page Content -->
<div class="container-fluid">
<a href="lista_proveedor.php" class="btn btn-primary">Regresar</a>

  <div class="row">
    <div class="col-lg-6 m-auto">
      <?php echo isset($alert) ? $alert : ''; ?>
      <form class="" action="" method="post">
        <input type="hidden" name="id" value="<?php echo $idproveedor; ?>">
        <div class="form-group">
          <label for="proveedor">Proveedor</label>
          <input type="text" placeholder="Ingrese proveedor" name="proveedor" class="form-control" id="proveedor" value="<?php echo $proveedor; ?>">
        </div>
        <div class="form-group">
          <label for="tipodeproveedor">TipoDeProveedor</label>
          <input type="text" placeholder="Ingrese tipo Proveedor" name="tipodeproveedor" class="form-control" id="tipodeproveedor" value="<?php echo $tipodeproveedor; ?>">
        </div>
        <div class="form-group">
          <label for="preciojaba">PrecioJaba</label>
          <input type="text" placeholder="Ingrese Peso de jaba" name="preciojaba" class="form-control" id="preciojaba" value="<?php echo $preciojaba; ?>">
        </div>
        <input type="submit" value="Editar Proveedor" class="btn btn-primary">
      </form>
    </div>
  </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>