<?php
include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";

  if (empty($_POST['cliente']) ||empty($_POST['proveedor']) || empty($_POST['preciodiario']) || empty($_POST['totaldejabas'])|| empty($_POST['montototal'])|| empty($_POST['saldopendiente'])) {
    $alert = '<div class="alert alert-danger" role="alert">
              Todo los campos son obligatorios
            </div>';
  } else {
    $idpagos = $_GET['id'];  
    $idcliente = $_POST['cliente'];
    $codproveedor = $_POST['proveedor'];
    $preciodiario = $_POST['preciodiario'];
    $totaldejabas = $_POST['totaldejabas'];
    $montototal = $_POST['montototal'];
    $saldopendiente = $_POST['saldopendiente'];
    
    $query_update = mysqli_query($conexion, "INSERT  registropagos(idpagos,idcliente,codproveedor,preciodiario,totaldejabas,montototal,saldopendiente)values('$idpagos', '$idpedido','$idcliente','$codproveedor,'$preciodiario','$totaldejabas','$montototal','$saldopendiente')");
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
  $query_registro = mysqli_query($conexion, "SELECT rc.idregistro,rc.codproveedor,rc.idcliente,IFNULL(rp.idpagos,0) as idpagos,c.nombre , p.proveedor,rc.preciodiario,rc.totaldejabas,rc.montoacobrar,'' as Pendiente, rc.fechapedido, rc.Estado 
  FROM registrocuentas rc 
  LEFT JOIN registropagos rp ON rc.idregistro=rp.Id_RegistroCuentas 
  LEFT JOIN cliente c ON c.idcliente=rc.idcliente LEFT JOIN proveedor p ON p.codproveedor=rc.codproveedor 
  where rc.idregistro=$idregistro");
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
              <label for="preciodiario">Precio Diario</label>                                                                                 
              <input type="number" placeholder="Ingrese el precio diario" name="preciodiario" id="preciodiario" class="form-control" value="<?php echo $data_registro['preciodiario']; ?>">
            </div>
            <div class="form-group">
              <label for="totaljaba">Total de jabas</label>
              <input type="number" placeholder="Ingrese el total de jaba" class="form-control" name="totaljaba" id="totaljaba" value="<?php echo $data_registro['totaljaba']; ?>">
            </div>
            <div class="form-group">
              <label for="pesototal">Peso Total</label>
              <input type="number" placeholder="Ingrese el peso total" class="form-control" name="pesototal" id="pesototal" value="<?php echo $data_registro['pesototal']; ?>">
            </div>
            <div class="form-group">
              <label for="montoacobrar">Monto a cobrar </label>
              <input type="number" placeholder="Ingrese el monto a cobrar " class="form-control" name="montoacobrar" id="montoacobrar" value="<?php echo $data_registro['montoacobrar']; ?>">
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