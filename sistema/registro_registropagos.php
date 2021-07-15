<?php include_once "includes/header.php";
  include "../conexion.php";
  if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['cliente']) ||empty($_POST['proveedor']) || empty($_POST['preciodiario']) || empty($_POST['totaljaba'])|| empty($_POST['montototal'])|| empty($_POST['saldopendiente']) ) {
      $alert = '<div class="alert alert-danger" role="alert">
                Todo los campos son obligatorios
              </div>';


    } else {
      
      $idcliente = $_POST['cliente'];
      $codproveedor = $_POST['proveedor'];
      $preciodiario = $_POST['preciodiario'];
      $fechapedido = $_POST['fechapedido'];
      $totaljaba = $_POST['totaljaba'];
      $montototal = $_POST['montototal'];
      $saldopendiente = $_POST['saldopendiente'];

      $query_insert = mysqli_query($conexion, "INSERT INTO registropagos(idcliente,codproveedor,fechapedido,preciodiario,totaljaba,montototal,saldopendiente) values ('$idcliente', '$codproveedor','$fechapedido','$preciodiario', '$totaljaba','$montototal','$saldopendiente')");
      if ($query_insert) {
        $alert = '<div class="alert alert-primary" role="alert">
                Precio Registrado
              </div>';
      } else {
        $alert = '<div class="alert alert-danger" role="alert">
                Error al registrar los Precios
              </div>';
      }
    }
}
?>

 <!-- Begin Page Content -->
 <div class="container-fluid">

   <!-- Page Heading -->
   <div class="d-sm-flex align-items-center justify-content-between mb-4">
     <h1 class="h3 mb-0 text-gray-800">Ingresar Nuevo Registro de Pago</h1>
     <a href="lista_registropagos.php" class="btn btn-primary">Regresar</a>
   </div>

   <!-- Content Row -->
   <div class="row">
     <div class="col-lg-6 m-auto">
       <form action="" method="post" autocomplete="off">
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
           <label for="fechapedido">Fecha de pedido</label>
           <input type="text" placeholder="Ingrese la fecha valida del pedido" class="form-control datepicker" name="fechapedido" id="fechapedido">
         </div>
         <div class="form-group">
           <label for="preciodiario">Precio Diario</label>
           <input type="Decimal" placeholder="Ingrese el precio diario" name="preciodiario" id="preciodiario" class="form-control">
         
         </div>
         <div class="form-group">
           <label for="totaljaba">Total de jabas</label>
           <input type="number" placeholder="Ingrese el total de las jabas" class="form-control" name="totaljaba" id="totaljaba">
         </div>
         <div class="form-group">
           <label for="montototal">Monto Total</label>
           <input type="number" placeholder="Ingrese el monto total" class="form-control" name="montototal" id="montototal">
         </div>
         <div class="form-group">
           <label for="saldopendiente">Saldo pendiente</label>
           <input type="number" placeholder="Ingrese el saldo pendiente" class="form-control" name="saldopendiente" id="saldopendiente">
         </div>


         <input type="submit" value="Guardar Registro de pago" class="btn btn-primary">
       </form>
     </div>
   </div>


 </div>
 <!-- /.container-fluid -->

 </div>
 <!-- End of Main Content -->
 <?php include_once "includes/footer.php"; ?>