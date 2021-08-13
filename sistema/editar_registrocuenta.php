<?php
include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['montoacobrar']) || empty($_POST['fechapedido']) || empty($_POST['idcliente']) || empty($_POST['idproveedor']) || empty($_POST['idproveedor'])) {
    $alert = '<div class="alert alert-danger" role="alert">
              Todo los campos son obligatorios 
            </div>';
  } else {
    $idregistro = $_GET['idcuenta'];
    $idpedido = $_GET['idpedido'];
    $idcliente = $_POST['idcliente'];
    $codproveedor = $_POST['idproveedor'];
    $fechapedido = $_POST['fechapedido'];
    $preciodiario = $_POST['preciodiario'];
    $totaldejabas = $_POST['totaldejabas'];
    $pesototal = $_POST['pesototal'];
    $pesoneto = $_POST['PesoNeto'];
    $totaldestare = $_POST['TotalDestare'];
    $montoacobrar = $_POST['montoacobrar'];
    $usuario_id = $_SESSION['idUser'];
    if ($idregistro != 0) {
      $query_insert = mysqli_query($conexion, "UPDATE registrocuentas SET idcliente = '$idcliente', codproveedor= '$codproveedor',preciodiario= '$preciodiario' ,totaldejabas='$totaldejabas',fechapedido='$fechapedido',pesototal='$pesototal',montoacobrar='$montoacobrar',TotalDestare='$totaldestare',PesoNeto='$pesoneto',Id_UserModify=$usuario_id,DateModify=NOW() WHERE idregistro = '$idregistro'");
    } else {
      $query_insert = mysqli_query($conexion, "INSERT INTO registrocuentas (idcliente,codproveedor,preciodiario,totaldejabas,fechapedido,pesototal,montoacobrar,estado,idpedido,TotalDestare,PesoNeto,Id_UserEntry,DateEntry) values ( '$idcliente','$codproveedor','$preciodiario','$totaldejabas','$fechapedido','$pesototal','$montoacobrar','A','$idpedido','$totaldestare','$pesoneto','$usuario_id',NOW())");
    }

    if ($query_insert) {
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

/// Validar producto

if (empty($_REQUEST['idcuenta']) && empty($_REQUEST['idpedido'])) {
  header("Location: lista_registrocuenta.php");
} else {
  $idcuenta = $_REQUEST['idcuenta'];
  $idpedido = $_REQUEST['idpedido'];
  if (!is_numeric($idcuenta) && !is_numeric($idpedido)) {
    header("Location: lista_registrocuenta.php");
  }
  $query_registro = mysqli_query($conexion, "select  *  from (SELECT rc.idregistro, rc.idpedido, cli.nombre ,rc.idcliente, pro.proveedor,rc.codproveedor,rc.totaldejabas,rc.TotalDestare AS TotalDestare , rc.preciodiario,rc.PesoNeto, ifnull(rc.pesototal,'') pesototal,ifnull(rc.montoacobrar,'') montoacobrar ,case when RC.idregistro is not null then 'Entregado' END as EstadoFlujo,rc.estado, rc.fechapedido
  FROM registrocuentas  rc  LEFT JOIN pedidos ped ON  rc.idpedido=ped.idpedido
LEFT JOIN cliente cli ON cli.idcliente=rc.idcliente
LEFT JOIN proveedor pro ON pro.codproveedor=rc.codproveedor 
where ped.idpedido is null and rc.estado='A'
UNION 
SELECT IFNULL(rc.idregistro,0) as idregistro , ped.idpedido, cli.nombre,ped.idcliente , pro.proveedor,ped.codproveedor,ped.totaldejabas,ped.totaldejabas*pro.pesojaba AS TotalDestare , ped.preciodiario,IFNULL(rc.PesoNeto,'') as PesoNeto, IFNULL(rc.pesototal,'') pesototal,ifnull(rc.montoacobrar,'') montoacobrar ,case when rc.idregistro is null then 'Pendiente de Entrega' ELSE 'Entregado' end as EstadoFlujo,ped.estado, ped.fechapedido 
 FROM pedidos ped 
 LEFT JOIN registrocuentas rc ON  ped.idpedido=rc.idpedido
                         LEFT JOIN  cliente cli ON cli.idcliente=ped.idcliente
                         LEFT JOIN proveedor pro ON pro.codproveedor=ped.codproveedor
              where ped.estado='A' ) as VRC where estado='A' and (vrc.idregistro='+$idcuenta' or '$idcuenta'=0) and (vrc.idpedido='$idpedido' or '$idpedido'=0)");
  $result_registro  = mysqli_num_rows($query_registro);

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
              <label>Proveedor</label>
              <?php
              $query_proveedor = mysqli_query($conexion, "SELECT codproveedor, proveedor FROM proveedor ORDER BY proveedor ASC");
              $resultado_proveedor = mysqli_num_rows($query_proveedor);

              ?>
              <select id="proveedor" name="proveedor" class="form-control" disabled="disabled">
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
            <div style="visibility:hidden;">
              <input type="text" style="visibility:hidden;" class="form-control" name="idproveedor" id="idproveedor" value="<?php echo $data_cuenta['codproveedor']; ?>">
            </div>
            <div class="form-group">
              <label>Cliente</label>
              <?php
              $query_cliente = mysqli_query($conexion, "SELECT idcliente, nombre FROM cliente ORDER BY nombre ASC");
              $resultado_cliente = mysqli_num_rows($query_cliente);
              mysqli_close($conexion);

              ?>
              <select id="cliente" name="cliente" class="form-control" disabled="disabled">
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
            <div style="visibility:hidden;">
              <input type="text" class="form-control" name="idcliente" id="idcliente" value="<?php echo $data_cuenta['idcliente']; ?>">
            </div>
            <div class="form-group">
              <label for="fechapedido">Fecha de pedido</label>
              <input type="text" placeholder="Ingrese la fecha valida del pedido" class="form-control datepicker" name="fechapedido" id="fechapedido" value="<?php echo $data_cuenta['fechapedido']; ?>">
            </div>
            <div class="form-group">
              <label for="preciodiario">Precio Diario</label>
              <input type="decimal" placeholder="Ingrese el precio diario" name="preciodiario" id="preciodiario" class="form-control" value="<?php echo $data_cuenta['preciodiario']; ?>">
            </div>
            <div class="form-group">
              <label for="totaljaba">Total de jabas</label>
              <input type="number" placeholder="Ingrese el total de jaba" class="form-control" name="totaldejabas" id="totaldejabas" value="<?php echo $data_cuenta['totaldejabas']; ?>">
            </div>
            <div class="form-group">
              <label for="pesototal">Peso Total</label>
              <input type="decimal" placeholder="Ingrese el peso total" class="form-control" name="pesototal" id="pesototal" value="<?php echo $data_cuenta['pesototal']; ?>">
            </div>
            <div class="form-group">
              <label for="TotalDestare">Total Destare</label>
              <input type="number" placeholder="Ingrese el peso total" class="form-control" name="TotalDestare" id="TotalDestare" value="<?php echo $data_cuenta['TotalDestare']; ?>">
            </div>
            <div class="form-group">
              <label for="PesoNeto">Peso Neto</label>
              <input type="decimal" placeholder="Ingrese el peso neto" class="form-control" name="PesoNeto" id="PesoNeto" value="<?php echo $data_cuenta['PesoNeto']; ?>">
            </div>
            <div class="form-group">
              <label for="montoacobrar">Monto a cobrar </label>
              <input type="decimal" placeholder="Ingrese el monto a cobrar " class="form-control" name="montoacobrar" id="montoacobrar" value="<?php echo $data_cuenta['montoacobrar']; ?>">
            </div>

            <input type="submit" value="Registrar peso y monto de pedido" class="btn btn-primary">
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
<script>
  $(document).ready(function() {

    var oListarPedidos;
    var oListaRegistros;
    $(Load);

    function Load() {
      InitAutocalculos();

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

        if (montocobrar <= 0) {
          $("#montoacobrar").val(0);
          $("#PesoNeto").val(0);
        } else {

          $("#PesoNeto").val(Math.round10(pesoneto, -1));
          $("#montoacobrar").val(Math.round10(montocobrar, -1));
        }
      });

    }

  });
</script>