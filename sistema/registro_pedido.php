<?php include_once "includes/header.php";
  include "../conexion.php";
  if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['cliente']) ||empty($_POST['proveedor']) || empty($_POST['preciodiario']) || empty($_POST['cjabamacho']) || empty($_POST['cjabamixto']) || empty($_POST['cjabahembra'])  ) {
      $alert = '<div class="alert alert-danger" role="alert">
                Todo los campos son obligatorios
              </div>';


    } else {
      
      $idcliente = $_POST['cliente'];
      $codproveedor = $_POST['proveedor'];
      $preciodiario = $_POST['preciodiario'];
      $cjabamacho = $_POST['cjabamacho'];
      $cjabamixto = $_POST['cjabamixto'];
      $cjabahembra = $_POST['cjabahembra'];
      
      $query_insert = mysqli_query($conexion, "INSERT INTO pedidos(idcliente,codproveedor,preciodiario,cjabamacho,cjabamixto,cjabahembra) values ('$idcliente', '$codproveedor', '$preciodiario', '$cjabamacho','$cjabamixto','$cjabahembra')");
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
     <h1 class="h3 mb-0 text-gray-800">Ingresar Nuevos pedidos</h1>
     <a href="lista_pedido.php" class="btn btn-primary">Regresar</a>
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
           <label for="preciocompra">preciodiario</label>
           <input type="Decimal" placeholder="Ingrese el precio compra" name="preciodiario" id="precioDiario" class="form-control">
         
         </div>
         <div class="form-group">
           <label for="precioVenta">cjabamacho</label>
           <input type="number" placeholder="Ingrese el precio precioVenta" class="form-control" name="cjabamacho" id="cjabamacho">
         </div>

    
         <div class="form-group">
           <label for="SubidaInterna">cjabamixto</label>
           <input type="number" placeholder="Ingrese el precio de Subida Interna" class="form-control" name="cjabamixto" id="cjabamixto">
         </div>

         <div class="form-group">
           <label for="PrecioVentaF">cjabahembra</label>
           <input type="number" placeholder="Ingrese el precio de Venta Final" class="form-control" name="cjabahembra" id="cjabahembra">
         </div>

         <!-- <div class="form-group">
           <label for="FechaCreacion">FechaCreacion</label>
           <input type="Datatime" placeholder="Ingrese el precio de Venta Final" class="form-control" name="fechaCreacion" id="fechaCreacion">
         </div>
         <div class="form-group">
           <label for="cantidad">Estado</label>
           <input type="text" placeholder="Ingrese el Estado" class="form-control" name="estado" id="estado">
         </div> -->
         <input type="submit" value="Guardar Precios" class="btn btn-primary">
       </form>
     </div>
   </div>


 </div>
 <!-- /.container-fluid -->

 </div>
 <!-- End of Main Content -->
 <?php include_once "includes/footer.php"; ?>