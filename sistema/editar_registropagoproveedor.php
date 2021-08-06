<?php
include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";

  if (empty($_POST['proveedor']) || empty($_POST['preciodiario']) || empty($_POST['totaljaba']) || empty($_POST['montototal']) || empty($_POST['montodepositado'])  ) {
    $alert = '<div class="alert alert-danger" role="alert">
              Todo los campos son obligatorios
            </div>';
  } else {
    $idpagoproveedor = $_GET['id'];
    $codproveedor = $_POST['proveedor'];
    $preciodiario = $_POST['preciodiario'];
    $totaljaba = $_POST['totaljaba'];
    $montototal = $_POST['montototal'];
    $montodepositado = $_POST['montodepositado'];
    $usuario_id = $_SESSION['idUser'];

    $query_update = mysqli_query($conexion, "UPDATE registropagoproveedor SET codproveedor = '$codproveedor', preciodiario= $preciodiario,totaljaba= $totaljaba ,montototal=$montototal,montodepositado=$montodepositado,Id_UserModify=$usuario_id,DateModify=NOW() WHERE idpagoproveedor = $idpagoproveedor");
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
  header("Location: lista_registropagoproveedor.php");
} else {
  $idpagoproveedor = $_REQUEST['id'];
  if (!is_numeric($idpagoproveedor)) {
    header("Location: lista_registropagoproveedor.php");
  }
  $query_registropagoproveedor = mysqli_query($conexion, "SELECT r.idpagoproveedor,  p.codproveedor , p.proveedor , r.preciodiario , r.totaljaba , r.montototal , r.montodepositado , r.fechapedido , r.estado FROM proveedor p INNER JOIN registropagoproveedor r ON p.codproveedor= r.codproveedor WHERE idpagoproveedor = $idpagoproveedor ");
  $result_registropagoproveedor = mysqli_num_rows($query_registropagoproveedor);

  if ($result_registropagoproveedor > 0) {
    $data_registropagoproveedor = mysqli_fetch_assoc($query_registropagoproveedor);
  } else {
    header("Location: lista_registropagoproveedor.php");
  }
}
?>
<!-- Begin Page Content -->
<div class="container-fluid">
<a href="lista_registropagoproveedor.php" class="btn btn-primary">Regresar</a>

  <div class="row">
    <div class="col-lg-6 m-auto">
      <div class="card">
        <div class="card-header bg-primary text-white">
          Modificar el pago del proveedor
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
                <option value="<?php echo $data_registropagoproveedor['codproveedor']; ?>" selected><?php echo $data_registropagoproveedor['proveedor']; ?></option>
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
              <label for="preciodiario">Precio diario</label>                                                                                 
              <input type="Decimal" placeholder="Ingrese el precio  Diario" name="preciodiario" id="preciodiario" class="form-control" value="<?php echo $data_registropagoproveedor['preciodiario']; ?>">
            
            </div>
            <div class="form-group">
              <label for="totaljaba">Total de jabas </label>
              <input type="Decimal" placeholder="Ingrese el Total de jabas " class="form-control" name="totaljaba" id="totaljaba" value="<?php echo $data_registropagoproveedor['totaljaba']; ?>">
            </div>

        
            <div class="form-group">
              <label for="montototal">Monto Total</label>
              <input type="Decimal" placeholder="Ingrese el Monto Total" class="form-control" name="montototal" id="montototal" value="<?php echo $data_registropagoproveedor['montototal']; ?>">
            </div>

            <div class="form-group">
              <label for="montodepositado">Monto depositado</label>
              <input type="Decimal" placeholder="Ingrese el monto depositado" class="form-control" name="montodepositado" id="montodepositado" value="<?php echo $data_registropagoproveedor['montodepositado']; ?>">
            </div>
            <input type="submit" value="Actualizar Registro de pago de proveedor" class="btn btn-primary">
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