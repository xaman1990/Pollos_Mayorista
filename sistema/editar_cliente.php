<?php include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['nombre']) ||empty($_POST['puntos']) || empty($_POST['telefono']) || empty($_POST['direccion'])) {
    $alert = '<p class"error">Todo los campos son requeridos</p>';
  } else {
    $idcliente = $_POST['id'];
    $puntos = $_POST['puntos'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $pesodejaba = $_POST['pesodejaba'];

      $sql_update = mysqli_query($conexion, "UPDATE cliente SET puntos = $puntos, nombre = '$nombre' , telefono = '$telefono', direccion = '$direccion',pesodejaba='$pesodejaba' WHERE idcliente = $idcliente");

      if ($sql_update) {
        $alert = '<p class"exito">Cliente Actualizado correctamente</p>';
      } else {
        $alert = '<p class"error">Error al Actualizar el Cliente</p>';
      }
    }
  }

// Mostrar Datos

if (empty($_REQUEST['id'])) {
  header("Location: lista_cliente.php");
}
$idcliente = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM cliente WHERE idcliente = $idcliente");
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
  header("Location: lista_cliente.php");
} else {
  while ($data = mysqli_fetch_array($sql)) {
    $idcliente = $data['idcliente'];
    $puntos = $data['puntos'];
    $nombre = $data['nombre'];
    $telefono = $data['telefono'];
    $direccion = $data['direccion'];
    $pesodejaba = $data['pesodejaba'];
  }
}
?>
        <!-- Begin Page Content -->
        <div class="container-fluid">
        <a href="lista_cliente.php" class="btn btn-primary">Regresar</a>

          <div class="row">
            <div class="col-lg-6 m-auto">

              <form class="" action="" method="post">
                <?php echo isset($alert) ? $alert : ''; ?>
                <input type="hidden" name="id" value="<?php echo $idcliente; ?>">
                <div class="form-group">
                  <label for="nombre">Nombre de cliente </label>
                  <input type="text" placeholder="Ingrese nombre del cliente " name="nombre" id="nombre" class="form-control" value="<?php echo $nombre; ?>">
                </div>
                <div class="form-group">
                  <label for="direccion">Direccion</label>
                  <input type="text" placeholder="Ingrese direccion del cliente " name="direccion" class="form-control" id="direccion" value="<?php echo $direccion; ?>">
                </div>
                <div class="form-group">
                  <label for="telefono">Telefono</label>
                  <input type="number" placeholder="Ingrese telefono del cliente " name="telefono" class="form-control" id="telefono" value="<?php echo $telefono; ?>">
                </div>
                <div class="form-group">
                  <label for="puntos">Puntos</label>
                  <input type="number" placeholder="Ingrese puntos del cliente " name="puntos" class="form-control" data-field="Amount" min="0.1" step="0.1"  id="puntos" value="<?php echo $puntos; ?>">
                </div>
                <div class="form-group">
                  <label for="pesodejaba">Peso de Jaba </label>
                  <input type="number" placeholder="Ingrese el Peso de Jaba " name="pesodejaba" class="form-control" data-field="Amount" min="0.1" step="0.1"  id="pesodejaba" value="<?php echo $pesodejaba; ?>">
                </div>

                <button type="submit" class="btn btn-primary"><i class="fas fa-user-edit"></i> Editar Cliente</button>
              </form>
            </div>
          </div>


        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
      <?php include_once "includes/footer.php"; ?>