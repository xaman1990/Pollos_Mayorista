<?php include_once "includes/header.php";
  include "../conexion.php";
  if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['proveedor']) || empty($_POST['preciodiario']) || empty($_POST['totaljaba']) || empty($_POST['montototal']) || empty($_POST['montodepositado'])|| empty($_POST['fechapedido'])  ) {
      $alert = '<div class="alert alert-danger" role="alert">
                Todo los campos son obligatorios
              </div>';
    } else {
     
      $codproveedor = $_POST['proveedor'];
      $preciodiario = $_POST['preciodiario'];
      $totaljaba = $_POST['totaljaba'];
      $montototal = $_POST['montototal'];
      $montodepositado = $_POST['montodepositado'];
      $fechapedido = $_POST['fechapedido'];

      $query_insert = mysqli_query($conexion, "INSERT INTO registropagoproveedor(codproveedor,preciodiario,totaljaba,montototal,montodepositado,fechapedido) values ('$codproveedor', '$preciodiario', '$totaljaba', '$montototal','$montodepositado','$fechapedido')");
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
     <h1 class="h3 mb-0 text-gray-800">Ingresar Nuevo pago de proveedor</h1>
     <a href="lista_registropagoproveedor.php" class="btn btn-primary">Regresar</a>
   </div>
   
   <!-- Content Row -->
   <div class="row">
     <div class="col-lg-6 m-auto">
       <form action="" method="post" autocomplete="off">
         <?php echo isset($alert) ? $alert : ''; ?>
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
           <input type="Decimal" placeholder="Ingrese el precio Diario" name="preciodiario" id="preciodiario" class="form-control">
         </div>
         <div class="form-group">
           <label for="totaljaba">Total de jabas </label>
           <input type="Decimal" placeholder="Ingrese el total de jabas" class="form-control" name="totaljaba" id="totaljaba">
         </div>
         <div class="form-group">
           <label for="montototal">Monto Total</label>
           <input type="Decimal" placeholder="Ingrese el monto Total" class="form-control" name="montototal" id="montototal">
         </div>
         <div class="form-group">
           <label for="montodepositado">Monto Depositado</label>
           <input type="Decimal" placeholder="Ingrese el Monto depositado" class="form-control" name="montodepositado" id="montodepositado">
         </div>
         <div class="form-group">
           <label for="fechapedido">Fecha de pedido</label>
           <input type="text" placeholder="Ingrese la fecha valida del pedido" class="form-control datepicker" name="fechapedido" id="fechapedido">
         </div>
         <input type="submit" value="Guardar Pago proveedor" class="btn btn-primary">
       </form>
     </div>
   </div>


 </div>
 <!-- /.container-fluid -->

 </div>
 <!-- End of Main Content -->
 <?php include_once "includes/footer.php"; ?>