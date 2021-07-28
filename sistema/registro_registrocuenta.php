<?php include_once "includes/header.php";
  include "../conexion.php";
  if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['cliente']) ||empty($_POST['proveedor']) || empty($_POST['preciodiario']) || empty($_POST['totaldejabas'])|| empty($_POST['pesototal'])|| empty($_POST['montoacobrar']) ) {
      echo '<script>
      Swal.fire({
            type: "error",
            title: "¡Todos los campos son obligatorios!",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
            }).then(function(result){
              if (result.value) {
              window.location = "lista_registrocuenta.php";
              }
          })
    </script>';


    } else {
      
      $idcliente = $_POST['cliente'];
      $codproveedor = $_POST['proveedor'];
      $preciodiario = $_POST['preciodiario'];
      $fechapedido = $_POST['fechapedido'];
      $totaldejabas = $_POST['totaldejabas'];
      $pesototal = $_POST['pesototal'];
      $montoacobrar = $_POST['montoacobrar'];
      $TotalDestare = $_POST['TotalDestare'];

      $query_insert = mysqli_query($conexion, "INSERT INTO registrocuentas(idcliente,codproveedor,fechapedido,preciodiario,totaldejabas,pesototal,montoacobrar,TotalDestare) values ('$idcliente', '$codproveedor','$fechapedido','$preciodiario', '$totaldejabas','$pesototal','$montoacobrar','$TotalDestare')");
      if ($query_insert) {
        echo '<script>
        Swal.fire({
          type: "success",
          title: "¡El precio fue creado!",
          showConfirmButton: true,
          confirmButtonText: "Cerrar"
          }).then(function(result){
            if (result.value) {
            window.location = "lista_registrocuenta.php";
            }
        })
  </script>';
  } else {
  echo '<script>
        Swal.fire({
          type: "error",
          title: "¡Error al crear al precio!",
          showConfirmButton: true,
          confirmButtonText: "Cerrar"
          }).then(function(result){
            if (result.value) {
            window.location = "lista_registrocuenta.php";
            }
        })
  </script>';
   }
  }
  }
  
?>

 <!-- Begin Page Content -->
 <div id="modalAgregarcuenta" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content" class="align-items-center">


  <!-- Page Heading -->
  <div class="modal-body">
  <div class="box-body">
          <div class="card-header bg-primary text-white">
            Registro Cuenta
          </div>
          <div class="card-body">
      <form action="" method="post" autocomplete="off">
        <?php echo isset($alert) ? $alert : ''; ?>
        <div class="form-group">
          <label>Proveedor</label>
          <?php
          $query_proveedor = mysqli_query($conexion, "SELECT codproveedor, proveedor FROM proveedor where estado='A' ORDER BY proveedor ASC");
          $resultado_proveedor = mysqli_num_rows($query_proveedor);

          ?>
          <select id="proveedor" name="proveedor" class="form-control" required>
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
          <label>Cliente</label>
          <?php
          $query_cliente = mysqli_query($conexion, "SELECT idcliente, nombre FROM cliente where estado='A' ORDER BY nombre ASC");
          $resultado_cliente = mysqli_num_rows($query_cliente);
          mysqli_close($conexion);
          ?>
          <select id="cliente" name="cliente" class="form-control" required>
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
           <label for="fechapedido">Fecha de pedido</label>
           <input type="text" placeholder="Ingrese la fecha valida del pedido" class="form-control datepicker" name="fechapedido" id="fechapedido">
         </div>
         <div class="form-group">
           <label for="preciodiario">Precio diario</label>
           <input type="number" placeholder="Ingrese el precio diario" name="preciodiario" id="preciodiario" class="form-control" data-field="Amount" min="0.1" step="0.1" required>
         
         </div>
         <div class="form-group">
           <label for="totaldejabas">Total de jabas</label>
           <input type="number" placeholder="Ingrese el total de las jabas" class="form-control" name="totaldejabas" id="totaldejabas">
         </div>
         <div class="form-group">
           <label for="pesototal">Peso Total</label>
           <input type="number" placeholder="Ingrese el peso total" class="form-control" name="pesototal" id="pesototal">
         </div>
         <div class="form-group">
           <label for="TotalDestare">Total Destare</label>
           <input type="number" placeholder="Ingrese el peso total" class="form-control" name="TotalDestare" id="TotalDestare">
         </div>
         <div class="form-group">
           <label for="montoacobrar">Monto a cobrar </label>
           <input type="number" placeholder="Ingrese el monto a cobrar" class="form-control" name="montoacobrar" id="montoacobrar">
         </div>

         <input type="submit" value="Guardar" class="btn col-lg-5 btn-primary">
         <a href="lista_registrocuenta.php" class="btn col-lg-5 btn-danger" align="center">Regresar</a>

       </form>
     </div>
   </div>


 </div>
 <!-- /.container-fluid -->

 </div>
 <!-- End of Main Content -->
 <?php include_once "includes/footer.php"; ?>

 <script>
  $(document).ready(function() {
    $("#preciodiario").click(function(e) {
      var fechavalidacionfil = $('#fechapedido').val();
      var codproveedorfil = $('#proveedor').val();
      $.ajax({
        url: 'controller/cuentaController.php',
        type: "POST",
        dataType: 'json',
        async: true,
        data: {
          fechavalidacionfil: fechavalidacionfil,
          codproveedorfil: codproveedorfil
        },
        success: function(response) {
          //var info = JSON.parse(response);
          //console.log(info); console.log("HERE : ", response)
          $('#preciodiario').val(response.PrecioVentaF);
        },
        error: function(error) {
          alert("No hay precio de venta definido para esa fecha y proveedor");
          $('#precioDiario').val("");
        },
      });
    });
  });
</script>