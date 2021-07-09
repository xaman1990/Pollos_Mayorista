<?php include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['nombre']) ||empty($_POST['puntos']) ||empty($_POST['preciodejaba']) || empty($_POST['telefono']) || empty($_POST['direccion'])) {
    $alert = '<p class"error">Todo los campos son requeridos</p>';
  } else {
    $idcliente = $_POST['id'];
    $puntos = $_POST['puntos'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $preciodejaba = $_POST['preciodejaba'];

    $result = 0;
    if (is_numeric($puntos) and $puntos != 0) {

      $query = mysqli_query($conexion, "SELECT * FROM cliente where (puntos = '$puntos' AND idcliente != $idcliente)");
      $result = mysqli_fetch_array($query);
      $resul = mysqli_num_rows($query);
    }

    //if ($resul >= 1) {
      //$alert = '<p class"error">El dni ya existe</p>';
    //} else {
      //if ($dni == '') {
        //$dni = 0;
     // }
      $sql_update = mysqli_query($conexion, "UPDATE cliente SET puntos = $puntos, nombre = '$nombre' , telefono = '$telefono', direccion = '$direccion',preciodejaba='$preciodejaba' WHERE idcliente = $idcliente");

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
    $preciodejaba = $data['preciodejaba'];
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
                  <label for="nombre">nombre</label>
                  <input type="text" placeholder="Ingrese nombre" name="nombre" id="nombre" class="form-control" value="<?php echo $nombre; ?>">
                </div>
                <div class="form-group">
                  <label for="telefono">telefono</label>
                  <input type="number" placeholder="Ingrese telefono" name="telefono" class="form-control" id="telefono" value="<?php echo $telefono; ?>">
                </div>
                <div class="form-group">
                  <label for="direccion">direccion</label>
                  <input type="text" placeholder="Ingrese direccion" name="direccion" class="form-control" id="direccion" value="<?php echo $direccion; ?>">
                </div>
                <div class="form-group">
                  <label for="puntos">puntos</label>
                  <input type="decimal" placeholder="Ingrese puntos" name="puntos" class="form-control" id="puntos" value="<?php echo $puntos; ?>">
                </div>
                <div class="form-group">
                  <label for="preciodejaba">preciodejaba</label>
                  <input type="decimal" placeholder="Ingrese preciodejaba" name="preciodejaba" class="form-control" id="preciodejaba" value="<?php echo $preciodejaba; ?>">
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