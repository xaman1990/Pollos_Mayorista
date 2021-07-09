<?php include_once "includes/header.php";
  include "../conexion.php";
  if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['proveedor']) || empty($_POST['precioCompra']) || empty($_POST['precioVenta']) || empty($_POST['subidaInterna']) || empty($_POST['precioVentaF'])|| empty($_POST['fechavalidacion'])  ) {
      $alert = '<div class="alert alert-danger" role="alert">
                Todo los campos son obligatorios
              </div>';
    } else {
     
      $codproveedor = $_POST['proveedor'];
      $preciocompra = $_POST['precioCompra'];
      $PrecioVenta = $_POST['precioVenta'];
      $SubidaInterna = $_POST['subidaInterna'];
      $PrecioVentaF = $_POST['precioVentaF'];
      $fechavalidacion = $_POST['fechavalidacion'];

      $query_insert = mysqli_query($conexion, "INSERT INTO precio(codproveedor,preciocompra,PrecioVenta,SubidaInterna,PrecioVentaF,fechavalidacion) values ('$codproveedor', '$preciocompra', '$PrecioVenta', '$SubidaInterna','$PrecioVentaF','$fechavalidacion')");
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
     <h1 class="h3 mb-0 text-gray-800">Ingresar Nuevos precios</h1>
     <a href="lista_precios.php" class="btn btn-primary">Regresar</a>
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
           <label for="preciocompra">preciocompra</label>
           <input type="Decimal" placeholder="Ingrese el precio compra" name="precioCompra" id="precioCompra" class="form-control">
         </div>
         <div class="form-group">
           <label for="precioVenta">precioVenta</label>
           <input type="Decimal" placeholder="Ingrese el precio precioVenta" class="form-control" name="precioVenta" id="precioVenta">
         </div>
         <div class="form-group">
           <label for="SubidaInterna">SubidaInterna</label>
           <input type="Decimal" placeholder="Ingrese el precio de Subida Interna" class="form-control" name="subidaInterna" id="subidaInterna">
         </div>
         <div class="form-group">
           <label for="PrecioVentaF">PrecioVentaF</label>
           <input type="Decimal" placeholder="Ingrese el precio de Venta Final" class="form-control" name="precioVentaF" id="precioVentaF">
         </div>
         <div class="form-group">
           <label for="fechavalidacion">fechavalidacion</label>
           <input type="text" placeholder="Ingrese la fecha valida del registro" class="form-control datepicker" name="fechavalidacion" id="fechavalidacion">
         </div>
         <input type="submit" value="Guardar Precios" class="btn btn-primary">
       </form>
     </div>
   </div>


 </div>
 <!-- /.container-fluid -->

 </div>
 <!-- End of Main Content -->
 <?php include_once "includes/footer.php"; ?>