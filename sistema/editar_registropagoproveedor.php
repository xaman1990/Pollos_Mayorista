<?php
include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";

  if (empty($_POST['proveedor']) || empty($_POST['preciodiario']) || empty($_POST['totaljaba']) || empty($_POST['montototal']) || empty($_POST['montodepositado'])) {
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
if (empty($_REQUEST['idregcuenta'])) {
  header("Location: lista_registropagoproveedor.php");
} else {
  $idregcuenta = $_REQUEST['idregcuenta'];
  if (!is_numeric($idregcuenta)) {
    header("Location: lista_registropagoproveedor.php");
  }
  $query_registropagoproveedor = mysqli_query($conexion, "select pre.idprecio,rc.idregistro,pro.proveedor,pre.preciocompra,sum(rc.totaldejabas) as totaldejabas,sum(rc.PesoNeto*pre.preciocompra) as MontoTotal,'' as Monto_Depositado,rc.fechapedido, rc.pesototal,rc.TotalDestare,rc.PesoNeto
  from registrocuentas rc
  left join precio pre on rc.codproveedor=pre.codproveedor and rc.fechapedido=pre.fechavalidacion and pre.Estado='A'
  left join proveedor pro on pro.codproveedor=rc.codproveedor
  left join cliente cli on rc.idcliente=cli.idcliente
  where pre.idprecio IS not null and rc.idregistro = $idregcuenta
  group by pro.proveedor,pre.preciocompra,rc.fechapedido  ");
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
              <label for="proveedor">Proveedor : <?php echo $data_registropagoproveedor['proveedor']; ?></label>
            </div>
            <div class="form-group">
              <label for="preciodiario">Precio diario : <?php echo $data_registropagoproveedor['preciocompra']; ?></label>

            </div>
            <div class="form-group">
              <label for="fechapedido">Fecha de pedido : <?php echo $data_registropagoproveedor['fechapedido']; ?></label>

            </div>
            <div class="form-group">
              <label for="totaljaba">Cantidad de jabas : <?php echo $data_registropagoproveedor['totaldejabas']; ?> </label>
            </div>


            <div class="form-group">
              <label for="pesototal">Peso Total</label>
              <input type="Decimal" placeholder="Ingrese el Peso Total" class="form-control" name="pesototal" id="pesototal" value="<?php echo $data_registropagoproveedor['pesototal']; ?>">
            </div>

            <div class="form-group">
              <label for="destare">Destare</label>
              <input type="Decimal" placeholder="Ingrese el destare" class="form-control" name="destare" id="destare" value="<?php echo $data_registropagoproveedor['TotalDestare']; ?>">
            </div>
            <div class="form-group">
              <label for="pesoneto">Peso Neto</label>
              <input type="Decimal" placeholder="Ingrese el peso neto" class="form-control" name="pesoneto" id="pesoneto" value="<?php echo $data_registropagoproveedor['PesoNeto']; ?>">
            </div>
            <div class="form-group">
              <label for="importepagar">Importe a Pagar</label>
              <input type="Decimal" placeholder="Ingrese el Importe a Pagar" class="form-control" name="importepagar" id="importepagar" value="<?php echo $data_registropagoproveedor['MontoTotal']; ?>">
            </div>
            <div class="form-group">
              <label for="montoacuenta">Monto a Cuenta</label>
              <input type="Decimal" placeholder="Ingrese el Importe a Pagar" class="form-control" name="montoacuenta" id="montoacuenta" >
            </div>
            <div class="form-group">
              <label for="saldoafavor">Saldo a Favor</label>
              <input type="Decimal" placeholder="Ingrese el Saldo a Favor" class="form-control" name="saldoafavor" id="saldoafavor" >
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