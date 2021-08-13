<?php include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['cliente']) ||empty($_POST['proveedor']) || empty($_POST['fechapedido']) || empty($_POST['preciodiario']) ||empty($_POST['totaldejabas']) ||empty($_POST['pesototal']) || empty($_POST['PesoNeto']) ||empty($_POST['TotalDestare']) ||empty($_POST['montoacobrar']) ) {
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
    $fechapedido = $_POST['fechapedido'];
    $preciodiario = $_POST['preciodiario'];
    $totaldejabas = $_POST['totaldejabas'];
    $pesototal = $_POST['pesototal'];
    $pesoneto = $_POST['PesoNeto'];
    $totaldestare = $_POST['TotalDestare'];
    $montoacobrar = $_POST['montoacobrar'];
    $usuario_id = $_SESSION['idUser'];
    $query_insert = mysqli_query($conexion, "INSERT INTO registrocuentas (idcliente,codproveedor,preciodiario,totaldejabas,fechapedido,pesototal,montoacobrar,estado,TotalDestare,PesoNeto,Id_UserEntry,DateEntry) values ( '$idcliente','$codproveedor','$preciodiario','$totaldejabas','$fechapedido','$pesototal','$montoacobrar','A','$totaldestare','$pesoneto','$usuario_id',NOW())");
    if ($query_insert) {
      echo '<script>
        Swal.fire({
          type: "success",
          title: "¡La cuenta fue creada!",
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
          title: "¡Error al crear la cuenta!",
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
                <label for="preciodiario">Precio Diario</label>
                <input type="decimal" placeholder="Ingrese el precio diario" name="preciodiario" id="preciodiario" class="form-control" ">
              </div>
              <div class=" form-group">
                <label for="totaljaba">Total de jabas</label>
                <input type="number" placeholder="Ingrese el total de jaba" class="form-control" name="totaldejabas" id="totaldejabas" ">
              </div>
              <div class=" form-group">
                <label for="pesototal">Peso Total</label>
                <input type="decimal" placeholder="Ingrese el peso total" class="form-control" name="pesototal" id="pesototal" ">
              </div>
              <div class=" form-group">
                <label for="TotalDestare">Total Destare</label>
                <input type="number" placeholder="Ingrese el peso total" class="form-control" name="TotalDestare" id="TotalDestare" ">
              </div>
              <div class=" form-group">
                <label for="PesoNeto">Peso Neto</label>
                <input type="decimal" placeholder="Ingrese el peso neto" class="form-control" name="PesoNeto" id="PesoNeto" ">
              </div>
              <div class=" form-group">
                <label for="montoacobrar">Monto a cobrar </label>
                <input type="decimal" placeholder="Ingrese el monto a cobrar " class="form-control" name="montoacobrar" id="montoacobrar" ">
              </div>


                <input type="submit" value="Guardar" class="btn col-lg-5 btn-primary">
                <a href="lista_registrocuenta.php" class="btn col-lg-5 btn-danger" align="center">Regresar</a>

            </form>
          </div>
        </div>


      </div>
      <!-- /.container-fluid -->

    </div>
  </div>
</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>

<script>
  $(document).ready(function() {
    $(Load);

    function Load() {
      TotalDestare();
      InitAutocalculos();
    }

    function TotalDestare() {

      var action = 'obtenerdestare';
      var codproveedor = $('#proveedor').val();
      var idcliente = $('#cliente').val();
      var totaljabas = $('#totaldejabas').val();
      $.ajax({
        url: 'controller/cuentasController.php',
        type: "POST",
        dataType: 'json',
        async: true,
        data: {
          action: action,
          idcliente: idcliente,
          codproveedor: codproveedor
        },
        success: function(response) {
          //var info = JSON.parse(response);
          //console.log(info); console.log("HERE : ", response)
          $('#TotalDestare').val(response.pesojaba * totaljabas);
        },
        error: function(error) {
          alert("No hay destare para el cliente");
          $('#TotalDestare').val("");
        },
      });
    }

    function InitAutocalculos() {
      var montocobrar = 0;
      var pesoneto = 0;
      $("#pesototal").keyup(function(event) {
        var pesototal = $("#pesototal").val();
        var totaldestare = $("#TotalDestare").val();
        var preciodiario = $("#preciodiario").val();
        pesoneto = pesototal - totaldestare;
        montocobrar = (pesototal - totaldestare) * preciodiario;
        TotalDestare();
        if (montocobrar <= 0) {
          $("#montoacobrar").val(0);
          $("#PesoNeto").val(0);
        } else {

          $("#PesoNeto").val(Math.round10(pesoneto, -1));
          $("#montoacobrar").val(Math.round10(montocobrar, -1));
        }
      });

    }

    $("#preciodiario").click(function(e) {

      var fechavalidacionfil = $('#fechapedido').val();
      var codproveedorfil = $('#proveedor').val();
      var idcliente = $('#cliente').val();
      $.ajax({
        url: 'controller/cuentaController.php',
        type: "POST",
        dataType: 'json',
        async: true,
        data: {
          idcliente: idcliente,
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


    $("#TotalDestare").click(function(e) {
      TotalDestare();
    });
  });
</script>