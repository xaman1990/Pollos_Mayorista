<?php include_once "includes/header.php";
  include "../conexion.php";
  if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['fechapedido']) || empty($_POST['pesototal']) || empty($_POST['destare']) || $_POST['pesonetojabas']|| empty($_POST['importe'])||empty($_POST['montocuenta'])||empty($_POST['saldoafavor'])) {
      $alert = '<div class="alert alert-danger" role="alert">
                Todo los campos son obligatorios
              </div>';
    } else {
      $fechapedido  = $_POST['fechapedido '];
      $pesototal = $_POST['pesototal'];
      $destare = $_POST['destare'];
      $pesonetojabas = $_POST['pesonetojabas'];
      $importe = $_SESSION['importe'];
      $montocuenta = $_SESSION['montocuenta'];
      $saldoafavor = $_SESSION['saldoafavor'];
      $usuario_id = $_SESSION['idUser'];
      $query_insert = mysqli_query($conexion, "INSERT INTO cuadre(fechapedido,pesototal,destare,pesonetojabas,importe,montocuenta,saldoafavor,Id_UserEntry,DateEntry) values ('$fechapedido', '$pesototal', '$destare', '$pesonetojabas','$importe','$montocuenta','$saldoafavor','$usuario_id',NOW())");
      if ($query_insert) {
        $alert = '<div class="alert alert-primary" role="alert">
                Producto Registrado
              </div>';
      } else {
        $alert = '<div class="alert alert-danger" role="alert">
                Error al registrar el producto
              </div>';
      }
    }
  }
  ?>

 <!-- Begin Page Content -->
 <div id="modalAgregarcuadre" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content" class="align-items-center">



      <!-- Content Row -->
      <div class="modal-body">

        <div class="box-body">
          <div class="card-header bg-primary text-white">
            Agregar cuadre
          </div>

   <!-- Content Row -->
   <div class="row">
     <div class="col-lg-6 m-auto">
       
       <form action="" method="post" autocomplete="off">
         <?php echo isset($alert) ? $alert : ''; ?>
         <div class="form-group">
           <label for="fechapedido">Fecha de pedido  </label>
           <input type="text" placeholder="Ingrese la fecha del pedido" class="form-control datepicker" name="fechapedido" id="fechapedido" required>
         </div>
         <div class="form-group">
           <label for="pesototal">Peso Total</label>
           <input type="number" placeholder="Ingrese el Peso total" class="form-control" name="pesototal" id="pesototal">
         </div>
         <div class="form-group">
           <label for="destare">Destare</label>
           <input type="number" placeholder="Ingrese el Destare" class="form-control" name="destare" id="destare">
         </div>
         <div class="form-group">
           <label for="pesonetojabas">Peso Neto de jabas</label>
           <input type="number" placeholder="Ingrese Peso Neto de jabas" class="form-control" name="pesonetojabas" id="pesonetojabas">
         </div>
         <div class="form-group">
           <label for="importe">Importe a pagar</label>
           <input type="number" placeholder="Ingrese Importe a pagar" class="form-control" name="importe" id="importe">
         </div>
         <div class="form-group">
           <label for="montocuenta">Monto Cuenta</label>
           <input type="number" placeholder="Ingrese Monto Cuenta" class="form-control" name="montocuenta" id="montocuenta">
         </div>
         <div class="form-group">
           <label for="montocuenta">Saldo a favor</label>
           <input type="number" placeholder="Ingrese Saldo a favor" class="form-control" name="montocuenta" id="montocuenta">
         </div>

         <input type="submit" value="Guardar Producto" class="btn btn-primary">
       </form>
     </div>
   </div>


 </div>
 <!-- /.container-fluid -->

 </div>
 <!-- End of Main Content -->
 <?php include_once "includes/footer.php"; ?>