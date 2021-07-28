<?php
include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";

  if (empty($_POST['cliente']) ||empty($_POST['proveedor']) || empty($_POST['preciodiario']) || empty($_POST['totaldejabas'])|| empty($_POST['pesototal'])|| empty($_POST['montoacobrar'])) {
    $alert = '<div class="alert alert-danger" role="alert">
              Todo los campos son obligatorios
            </div>';
  } else {
    $idregistro = $_GET['idregistro'];  
    $idcliente = $_POST['cliente'];
    $codproveedor = $_POST['proveedor'];
    $preciodiario = $_POST['preciodiario'];
    $totaldejabas = $_POST['totaldejabas'];
    $pesototal = $_POST['pesototal'];
    $montoacobrar = $_POST['montoacobrar'];
    
    $query_update = mysqli_query($conexion, "INSERT  registrocuentas(idregistro,idpedido,idcliente,codproveedor,preciodiario,totaldejabas,pesototal,montoacobrar)values('$idregistro', '$idpedido','$idcliente','$codproveedor,'$preciodiario','$totaldejabas','$pesototal','$montoacobrar')");
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
  header("Location: lista_registrocuenta.php");
} else {
  $idregistro = $_REQUEST['id'];
  if (!is_numeric($idregistro)) {
    header("Location: lista_registrocuenta.php");
  }
  $query_registro = mysqli_query($conexion, "SELECT rc.idregistro, rc.idpedido, cli.nombre , pro.proveedor,rc.totaldejabas,rc.TotalDestare AS TotalDestare , rc.preciodiario,rc.PesoNeto, ifnull(rc.pesototal,'') pesototal,ifnull(rc.montoacobrar,'') montoacobrar ,pro.Estado, rc.fechapedido
  FROM registrocuentas  rc  LEFT JOIN pedidos ped ON  rc.idpedido=ped.idpedido
LEFT JOIN cliente cli ON cli.idcliente=rc.idcliente
LEFT JOIN proveedor pro ON pro.codproveedor=rc.codproveedor
UNION 
SELECT rc.idregistro, rc.idpedido, cli.nombre , pro.proveedor,ped.totaldejabas,ped.totaldejabas*pro.pesojaba AS TotalDestare , ped.preciodiario,rc.PesoNeto, ifnull(rc.pesototal,'') pesototal,ifnull(rc.montoacobrar,'') montoacobrar ,pro.Estado, ped.fechapedido 
 FROM pedidos ped 
 LEFT JOIN registrocuentas rc ON  ped.idpedido=rc.idpedido
                         LEFT JOIN  cliente cli ON cli.idcliente=ped.idcliente
                         LEFT JOIN proveedor pro ON pro.codproveedor=ped.codproveedor
    ");
  $result_registro  = mysqli_num_rows($query_registro );

  if ($result_registro > 0) {
    $data_cuenta = mysqli_fetch_assoc($query_registro);
  } else {
    header("Location: lista_registrocuenta.php");
  }
}
?>
<!-- Begin Page Content -->
<div class="container-fluid">
<a href="lista_registrocuenta.php" class="btn btn-primary">Regresar</a>

  <div class="row">
    <div class="col-lg-6 m-auto">
      <div class="card">
        <div class="card-header bg-primary text-white">
          Modificar Registro de cuenta
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
           <option value="<?php echo $data_cuenta['idcliente']; ?>" selected><?php echo $data_cuenta['nombre']; ?></option>
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
           <option value="<?php echo $data_cuenta['codproveedor']; ?>" selected><?php echo $data_cuenta['proveedor']; ?></option>

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