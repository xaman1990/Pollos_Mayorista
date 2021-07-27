<?php
include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";

  if (empty($_POST['cliente']) ||empty($_POST['proveedor']) || empty($_POST['preciodiario']) || empty($_POST['cjabamacho']) || empty($_POST['cjabamixto']) || empty($_POST['cjabahembra'])  ) {
    $alert = '<div class="alert alert-danger" role="alert">
              Todo los campos son obligatorios
            </div>';
  } else {
    $idpedido = $_GET['id'];  
    $idcliente = $_POST['cliente'];
    $codproveedor = $_POST['proveedor'];
    $preciodiario = $_POST['preciodiario'];
    $cjabamacho = $_POST['cjabamacho'];
    $cjabamixto = $_POST['cjabamixto'];
    $cjabahembra = $_POST['cjabahembra'];
    $totaldejabas = $cjabamacho+$cjabamixto+$cjabahembra;
    $query_update = mysqli_query($conexion, "UPDATE pedidos SET idcliente=$idcliente ,codproveedor=$codproveedor,preciodiario=$preciodiario,cjabamacho=$cjabamacho,cjabamixto=$cjabamixto,cjabahembra=$cjabahembra, totaldejabas=$cjabamacho+$cjabamixto+$cjabahembra WHERE idpedido=$idpedido");
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
  header("Location: lista_pedido.php");
} else {
  $idpedido = $_REQUEST['id'];
  if (!is_numeric($idpedido)) {
    header("Location: lista_pedido.php");
  }
  $query_pedido = mysqli_query($conexion, "SELECT idpedido,c.idcliente ,p.codproveedor, p.proveedor, c.nombre ,r.codproveedor, r.preciodiario , r.cjabamacho , r.cjabamixto , r.cjabahembra , r.fechapedido , r.estado  FROM 
  cliente c  INNER JOIN pedidos r ON c.idcliente= r.idcliente INNER JOIN proveedor p ON p.codproveedor=r.codproveedor WHERE idpedido = $idpedido");
  $result_pedido = mysqli_num_rows($query_pedido);

  if ($result_pedido > 0) {
    $data_pedido = mysqli_fetch_assoc($query_pedido);
  } else {
    header("Location: lista_pedido.php");
  }
}
?>
<!-- Begin Page Content -->
<div class="container-fluid">
<a href="lista_pedido.php" class="btn btn-primary">Regresar</a>

  <div class="row">
    <div class="col-lg-6 m-auto">
      <div class="card">
        <div class="card-header bg-primary text-white">
          Modificar pedido
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
           <select id="proveedor" name="proveedor" class="form-control">
           <option value="<?php echo $data_pedido['codproveedor']; ?>" selected><?php echo $data_pedido['proveedor']; ?></option>
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
            $query_cliente = mysqli_query($conexion, "SELECT idcliente, nombre FROM cliente ORDER BY nombre ASC");
            $resultado_cliente = mysqli_num_rows($query_cliente);
            ?>
           <select id="cliente" name="cliente" class="form-control"> 
             <option value="<?php echo $data_pedido['idcliente']; ?>" selected><?php echo $data_pedido['nombre']; ?></option>
           
             <?php
              if ($resultado_cliente > 0) {
                while ($cliente = mysqli_fetch_array($query_cliente)) {
                  mysqli_close($conexion);

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
              <label for="preciodiario">Precio diario</label>                                                                                 
              <input type="number" placeholder="Ingrese el precio diario" name="preciodiario" id="precioDiario" class="form-control" value="<?php echo $data_pedido['preciodiario']; ?>">
            </div>
            <div class="form-group">
              <label for="cjabamacho">Jabas de Macho</label>
              <input type="number" placeholder="Ingrese Jabas de Macho" class="form-control" name="cjabamacho" id="cjabamacho" value="<?php echo $data_pedido['cjabamacho']; ?>">
            </div>

        
            <div class="form-group">
              <label for="cjabamixto">Jabas de Mixto</label>
              <input type="number" placeholder="Ingrese Jabas de Mixto" class="form-control" name="cjabamixto" id="cjabamixto" value="<?php echo $data_pedido['cjabamixto']; ?>">
            </div>

            <div class="form-group">
              <label for="cjabahembra">Jabas de Hembra</label>
              <input type="number" placeholder="Ingrese Jabas de Hembra" class="form-control" name="cjabahembra" id="cjabahembra" value="<?php echo $data_pedido['cjabahembra']; ?>">
            </div>
            <input type="submit" value="Actualizar Precio" class="btn btn-primary">
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