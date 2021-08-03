<?php
include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";

  if (empty($_POST['fechapedido']) || empty($_POST['dudashistorico']) || empty($_POST['depafy']) || empty($_POST['Montodepositado']) || empty($_POST['montocuenta'])  ) {
    $alert = '<div class="alert alert-danger" role="alert">
              Todo los campos son obligatorios
            </div>';
  } else {
    $idcuadre = $_GET['id'];
    $fechapedido = $_POST['fechapedido'];
    $dudashistorico = $_POST['dudashistorico'];
    $depafy = $_POST['depafy'];
    $Montodepositado = $_POST['Montodepositado'];
    $montocuenta = $_POST['montocuenta'];
    $query_update = mysqli_query($conexion, "UPDATE ");
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
  header("Location: lista_cuadre.php");
} else {
  $idcuadre = $_REQUEST['id'];
  if (!is_numeric($idcuadre)) {
    header("Location: lista_cuadre.php");
  }
  $query_cuadre = mysqli_query($conexion, "SELECT");
  $result_cuadre = mysqli_num_rows($query_cuadre);

  if ($result_cuadre> 0) {
    $data_cuadre = mysqli_fetch_assoc($query_cuadre);
  } else {
    header("Location: lista_cuadre.php");
  }
}
?>
<!-- Begin Page Content -->
<div class="container-fluid">
<a href="lista_cuadre.php" class="btn btn-primary">Regresar</a>

  <div class="row">
    <div class="col-lg-6 m-auto">
      <div class="card">
        <div class="card-header bg-primary text-white">
          Modificar cuadre
        </div>
            <div class="form-group">
              <label for="fechapedido">Fecha pedido</label>                                                                                 
              <input type="text" placeholder="Ingrese la fecha del pedido" name="fechapedido" id="fechapedido" class="form-control" value="<?php echo $data_cuadre['fechapedido']; ?>">
            </div>
            <div class="form-group">
              <label for="dudashistorico">Dudas Historico</label>
              <input type="text" placeholder="Ingrese Dudas Historico" class="form-control" name="dudashistorico" id="dudashistorico" value="<?php echo $data_cuadre['dudashistorico']; ?>">
            </div>

        
            <div class="form-group">
              <label for="depafy">Dep AF Y</label>
              <input type="number" placeholder="Ingrese Dep AF Y " class="form-control" name="depafy" id="depafy" value="<?php echo $data_cuadre['depafy']; ?>">
            </div>

            <div class="form-group">
              <label for="Montodepositado">Monto depositado</label>
              <input type="number" placeholder="Ingrese Monto depositado" class="form-control" name="Montodepositado" id="Montodepositado" value="<?php echo $data_cuadre['Montodepositado']; ?>">
            </div>
            <div class="form-group">
              <label for="Montodepositado">montocuenta</label>
              <input type="number" placeholder="Ingrese monto a cuenta " class="form-control" name="montocuenta" id="montocuenta" value="<?php echo $data_cuadre['montocuenta']; ?>">
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