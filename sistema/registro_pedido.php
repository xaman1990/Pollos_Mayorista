<?php include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['cliente']) || empty($_POST['proveedor']) || empty($_POST['preciodiario']) || empty($_POST['cjabamacho']) || empty($_POST['cjabamixto']) || empty($_POST['cjabahembra'])) {
    echo '<script>
    Swal.fire({
          type: "error",
          title: "¡Todos los campos son obligatorios!",
          showConfirmButton: true,
          confirmButtonText: "Cerrar"
          }).then(function(result){
            if (result.value) {
            window.location = "lista_pedido.php";
            }
        })
  </script>';
  } else {

    $idcliente = $_POST['cliente'];
    $codproveedor = $_POST['proveedor'];
    $fechapedido = $_POST['fechapedido'];
    $preciodiario = $_POST['preciodiario'];
    $cjabamacho = $_POST['cjabamacho'];
    $cjabamixto = $_POST['cjabamixto'];
    $cjabahembra = $_POST['cjabahembra'];
    $totaldejabas = $cjabamacho+$cjabamixto+$cjabahembra;

    $query_insert = mysqli_query($conexion, "INSERT INTO pedidos(idcliente,codproveedor,fechapedido,preciodiario,cjabamacho,cjabamixto,cjabahembra,totaldejabas) values ('$idcliente', '$codproveedor','$fechapedido', '$preciodiario', '$cjabamacho','$cjabamixto','$cjabahembra','$totaldejabas')");
    if ($query_insert) { 
      echo '<script>
      Swal.fire({
        type: "success",
        title: "¡El precio fue creado!",
        showConfirmButton: true,
        confirmButtonText: "Cerrar"
        }).then(function(result){
          if (result.value) {
          window.location = "lista_pedido.php";
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
          window.location = "lista_pedido.php";
          }
      })
</script>';
 }
}
}

?>
<!-- Begin Page Content -->
<div id="modalAgregarpedido" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content" class="align-items-center">


  <!-- Page Heading -->
  <div class="modal-body">
  <div class="box-body">
          <div class="card-header bg-primary text-white">
            Registro pedido
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
          
            <label for="fechapedido">Fecha de Pedido</label>
            <input type="text" placeholder="Ingrese la fecha  de pedido  " class="form-control datepicker" name="fechapedido" id="fechapedido" required>
            <input type="button" name="Validar" id="Validar" value="Validar" class="btn btn-info active" />
         
          </div>
        <div class="form-group">
          <label for="Precio Diario">Precio Diario</label>

          <input type="number" placeholder="Ingrese el precio diario" name="preciodiario" id="precioDiario" class="form-control" data-field="Amount" min="0.1" step="0.1" required>

        </div>
        <div class="form-group">
          <label for="Jabas de Macho">Jabas de Macho</label>
          <input type="number" placeholder="Ingrese Las jabas de Macho" class="form-control" name="cjabamacho" id="cjabamacho">
        </div>


        <div class="form-group">
          <label for="Jabas de Mixto">Jabas de Mixto</label>
          <input type="number" placeholder="Ingrese Las bajas de Mixto" class="form-control" name="cjabamixto" id="cjabamixto">
        </div>

        <div class="form-group">
          <label for="Jabas de Hembra">Jabas de Hembra </label>
          <input type="number" placeholder="Ingrese las Jabas de hembra" class="form-control" name="cjabahembra" id="cjabahembra">
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

<script>
  $(document).ready(function() {
    $("#precioDiario").click(function(e) {
      var fechavalidacionfil = $('#fechapedido').val();
      var codproveedorfil = $('#proveedor').val();
      var action="obtenerprecio"
      $.ajax({
        url: 'controller/pedidoController.php',
        type: "POST",
        dataType: 'json',
        async: true,
        data: {
          action:action,
          fechavalidacionfil: fechavalidacionfil,
          codproveedorfil: codproveedorfil
        },
        success: function(response) {
          //var info = JSON.parse(response);
          //console.log(info); console.log("HERE : ", response)
          $('#precioDiario').val(response.PrecioVentaF);
        },
        error: function(error) {
          alert("No hay precio de venta definido para esa fecha y proveedor");
          $('#precioDiario').val("");
        },
      });
    });
  });
</script>