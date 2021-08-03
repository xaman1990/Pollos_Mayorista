<?php
include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";

  if (empty($_POST['cliente']) ||empty($_POST['proveedor']) || empty($_POST['montototal'])|| empty($_POST['PagoCuenta'])||empty($_POST['fechapedido'])) {
    $alert = '<div class="alert alert-danger" role="alert">
              Todo los campos son obligatorios
            </div>';
  } else {
    $id_registrocuenta = $_GET['id'];  
    $idcliente = $_POST['cliente'];
    $codproveedor = $_POST['proveedor'];    
    $fechapedido = $_POST['fechapedido'];
    $montototal = $_POST['montototal'];
    $pagocuenta = $_POST['PagoCuenta'];
    $saldopendiente=$_POST['saldopendiente'];
    $saldopendiente_Insertar=$saldopendiente-$pagocuenta;
    $usuario_id = $_SESSION['idUser'];

    $query_update = mysqli_query($conexion, "INSERT INTO registropagos(Id_RegistroCuentas,idcliente,codproveedor,fechapedido,montototal,saldopendiente,PagoaCuenta,Id_UserEntry,DateEntry) values ('$id_registrocuenta', '$idcliente','$codproveedor','$fechapedido','$montototal',$saldopendiente_Insertar,'$pagocuenta','$usuario_id',NOW())");
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
  header("Location: lista_registropagos.php");
} else {
  $idregistro = $_REQUEST['id'];
  if (!is_numeric($idregistro)) {
    header("Location: lista_registropagos.php");
  }
  $query_registro = mysqli_query($conexion, " SELECT rc.idregistro,rc.codproveedor,rc.idcliente,c.nombre as cliente , p.proveedor,rc.preciodiario,rc.totaldejabas,rc.montoacobrar,rc.montoacobrar-sum(ifnull(PagoaCuenta,0)) as Pendiente, rc.fechapedido, rc.Estado 
  FROM registrocuentas rc 
  LEFT JOIN registropagos rp ON rc.idregistro=rp.Id_RegistroCuentas 
  LEFT JOIN cliente c ON c.idcliente=rc.idcliente LEFT JOIN proveedor p ON p.codproveedor=rc.codproveedor   where rc.idregistro=$idregistro
  GROUP BY rc.idregistro,rc.codproveedor,rc.idcliente,c.nombre  , p.proveedor,rc.preciodiario,rc.totaldejabas,rc.montoacobrar, rc.fechapedido, rc.Estado
");
  $result_registro  = mysqli_num_rows($query_registro );

  if ($result_registro > 0) {
    $data_registro = mysqli_fetch_assoc($query_registro);
  } else {
    header("Location: lista_registropagos.php");
  }
}
?>
<!-- Begin Page Content -->
<div class="container-fluid">
<a href="lista_registropagos.php" class="btn btn-primary">Regresar</a>

  <div class="row">
    <div class="col-lg-6 m-auto">
      <div class="card">
        <div class="card-header bg-primary text-white">
          Modificar Registro de pago
        </div>
        <div class="card-body">
          <form action="" method="post">
            <?php echo isset($alert) ? $alert : ''; ?>

         <div class="form-group">
           <label>Cliente</label>
           <?php
            $query_cliente = mysqli_query($conexion, "SELECT idcliente, nombre FROM cliente ORDER BY nombre ASC");
            $resultado_cliente = mysqli_num_rows($query_cliente);
            ?>
           <select id="cliente" name="cliente" class="form-control">
           <option value="<?php echo $data_registro['idcliente']; ?>" selected><?php echo $data_registro['cliente']; ?></option>

             <?php
              if ($resultado_cliente > 0) {
                while ($cliente = mysqli_fetch_array($query_cliente)) {
                  // code...
              ?>
                 <option value="<?php echo $cliente['idcliente']; ?>"><?php echo $cliente['nombre']; ?></option>
             <?php
                }
              }
              ?>
           </select>
         </div>
         <div class="form-group">
           <label>Proveedor</label>
           <?php
            $query_proveedor = mysqli_query($conexion, "SELECT codproveedor, proveedor FROM proveedor ORDER BY proveedor ASC");
            $resultado_proveedor = mysqli_num_rows($query_proveedor);
            mysqli_close($conexion);

            ?>
           <select id="proveedor" name="proveedor" class="form-control">
           <option value="<?php echo $data_registro['codproveedor']; ?>" selected><?php echo $data_registro['proveedor']; ?></option> 
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
              <label for="fechapedido">Fecha pedido</label>
              <input type="text" placeholder="Ingrese la fecha del pedido" class="form-control datepicker" name="fechapedido" id="fechapedido" value="<?php echo $data_registro['fechapedido']; ?>">
            </div>
         <div class="form-group">
              <label for="montototal">Monto total</label>                                                                                 
              <input type="number" placeholder="Ingrese monto total" name="montototal" id="montototal" class="form-control" value="<?php echo $data_registro['montoacobrar']; ?>">
            </div>
            <div style="visibility:hidden;">
                                                                                          
              <input type="number"  name="saldopendiente" id="saldopendiente" class="form-control" value="<?php echo $data_registro['Pendiente']; ?>">
            </div>
            <div class="form-group">
              <label for="PagoCuenta">Pago cuenta  </label>
              <input type="decimal" data-field="Amount" min="0.1" step="0.1" placeholder="Ingrese el pago de la cuenta  " class="form-control" name="PagoCuenta" id="PagoCuenta" value="<?php echo $data_registro['Pendiente']; ?>">
            </div>

            <input type="submit" value="Actualizar registro de cuenta" class="btn btn-primary">
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