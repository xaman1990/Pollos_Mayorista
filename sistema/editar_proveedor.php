<?php
include "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['proveedor']) || empty($_POST['tipoproveedor'])|| empty($_POST['pesojaba']))  {
    $alert = '<p class"msg_error">Todo los campos son requeridos</p>';
  } else {
    $idproveedor = $_GET['id'];
    $proveedor = $_POST['proveedor'];
    $tipoproveedor = $_POST['tipoproveedor'];
    $pesojaba = $_POST['pesojaba'];

    $sql_update = mysqli_query($conexion, "UPDATE proveedor SET proveedor = '$proveedor', tipoproveedor = '$tipoproveedor', pesojaba='$pesojaba' WHERE codproveedor = $idproveedor");

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

$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
  header("Location: lista_proveedor.php");
} else {
  while ($data = mysqli_fetch_array($sql)) {
    $idproveedor = $data['codproveedor'];
    $proveedor = $data['proveedor'];
    $idtipoproveedor = $data['tipoproveedor'];
    $pesojaba = $data['pesojaba'];
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
                    <label>Tipo de proveedor</label>
                    <select name="tipoproveedor" id="tipoproveedor" class="form-control">
                        <?php
                        $query_tipoproveedor = mysqli_query($conexion, "select * from tipoproveedor");
                        mysqli_close($conexion);
                        $resultado_tipoproveedor = mysqli_num_rows($query_tipoproveedor);
                        if ($resultado_tipoproveedor > 0) {
                            while ($tipoproveedor = mysqli_fetch_array($query_tipoproveedor)) {
                        ?>
                                <option value="<?php echo $tipoproveedor["idtipoproveedor"]; ?>" <?php
                              if ($tipoproveedor["idtipoproveedor"] == $idtipoproveedor) {
                                echo "selected";
                              }
                              ?> ><?php echo $tipoproveedor["tipoproveedor"] ?></option>
                        <?php

                            }
                        }

                        ?>
                    </select></div>
        <div class="form-group">
          <label for="pesojaba">Peso de la Jaba</label>
          <input type="number" placeholder="Ingrese Peso de jaba" name="pesojaba" class="form-control" id="pesojaba" value="<?php echo $pesojaba; ?>">
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
