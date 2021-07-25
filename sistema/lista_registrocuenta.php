<?php include_once "includes/header.php"; 

$where = "r.Estado='A'";


if (!empty($_REQUEST['fecha_de']) || !empty($_REQUEST['fecha_a'])||!empty($_REQUEST['cb_proveedor'])) {
	$fecha_de = $_REQUEST['fecha_de'];
	$fecha_a = $_REQUEST['fecha_a'];
	$cb_Proveedor=$_REQUEST['cb_proveedor'];
	if ($fecha_de > $fecha_a) {
	} else if ($fecha_de == $fecha_a) {
		$where = " p.Fechapedido=DATE_FORMAT('$fecha_de', '%m/%d/%Y') and p.Estado='A' and p.codproveedor='$cb_Proveedor' ";
	} else {
		$f_de = date("Y-m-d", strtotime($fecha_de . "0 days"));
		$f_a =  date("Y-m-d", strtotime($fecha_a . "+ 1 days"));

		$where = " p.Fechapedido BETWEEN DATE_FORMAT('$f_de', '%m/%d/%Y') AND DATE_FORMAT('$f_a', '%m/%d/%Y') and p.Estado='A' and (p.codproveedor='$cb_Proveedor' or '$cb_Proveedor'='')";
		$buscar = "fecha_de=$fecha_de&fecha_a=$fecha_a  ";
	}
} else if (empty($_REQUEST['fecha_de']) || empty($_REQUEST['fecha_a']) || empty($_REQUEST['cb_proveedor'])) {
	$where = "p.Estado='A'  ";
}

?>


<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Lista de Registro de cuentas</h1>
		<?php if ($_SESSION['rol'] == 1) { ?>
		<button class="btn btn-info" data-toggle="modal" data-target="#modalAgregarcuenta" style="float:right">
		Nuevo registro cuenta 
		</button>

		<?php } ?>
	</div>
	<div>
		<h5> buscar por fecha </h5>
		<form action="lista_registrocuenta.php" method="get" class="form_search_date">
			<label>DE: </label>
			<input type="date" name="fecha_de" id="fecha_de" value="<?php echo $fecha_de; ?>" required>
			<label> A </label>
			<input type="date" name="fecha_a" id="fecha_a" value="<?php echo $fecha_a; ?>" required>
			<label for="nombre">Proveedor</label>
                <?php
				include "../conexion.php";
				$query_proveedor = mysqli_query($conexion, "SELECT * FROM proveedor where estado='A' ORDER BY proveedor ASC");
                $resultado_proveedor = mysqli_num_rows($query_proveedor);
                ?>
				<form action="lista_pedido.php" method="get" class="form_search_date">
                <select id="cb_proveedor" name="cb_proveedor">
                  <option value="" selected>Ninguno</option>
                  <?php
                  if ($resultado_proveedor > 0) 
				  {
                    while ($proveedor = mysqli_fetch_array($query_proveedor)) {
                      // code...
                      if ($resultado_tipoproveedor > 0) 
                                       {
                  ?>
                      <option value="<?php echo $proveedor["codproveedor"]; ?>"><?php echo $proveedor["proveedor"]; ?></option>
                  <?php
                    }else{
					?>
					<option value="<?php echo $proveedor["codproveedor"]; ?>"><?php echo $proveedor["proveedor"]; ?></option>
					<?php	
					}
                  }
				}
                  ?>
                </select>

				<label for="nombre">Cliente</label>
          <?php
		  				include "../conexion.php";
          $query_cliente = mysqli_query($conexion, "SELECT idcliente, nombre FROM cliente where estado='A' ORDER BY nombre ASC");
          $resultado_cliente = mysqli_num_rows($query_cliente);
          mysqli_close($conexion);
          ?>
          <select id="cliente" name="cliente">
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
			<button type="submit" class="btn btn-info"><i class="fas fa-search"></i>Listar</button>
			<a href="lista_reportecuenta.php" class="btn btn-primary">Reporte de pedidos</a>

	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="table">
					<thead class="thead-dark">
						<tr>
						    <th>NombreCliente</th> 
							<th>NombreProveedor</th>
							<th>Precio Diario</th>
							<th>Total jaba</th>
							<th>Peso Total </th>
							<th>Total Destare</th>
							<th>Peso Neto</th>
							<th>Monto Cobrar</th>
							<th>Fecha de pedido</th>
							<th>Estado</th>
							<?php if ($_SESSION['rol'] == 1) { ?>
							<th>ACCIONES</th>
							<?php }?>
						</tr>
					</thead>
					<tbody>
						<?php
						include "../conexion.php";

						$query = mysqli_query($conexion, "SELECT rc.idregistro, rc.idpedido, c.nombre , p.proveedor,r.totaldejabas,r.totaldejabas*p.pesojaba AS TotalDestare , r.preciodiario,rc.PesoNeto, ifnull(rc.pesototal,'') pesototal,ifnull(rc.montoacobrar,'') montoacobrar , p.Estado, p.fechadecreacion 
						FROM pedidos r 
						LEFT JOIN registrocuentas rc ON  r.idpedido=rc.idpedido
												LEFT JOIN  cliente c ON c.idcliente=r.idcliente
												LEFT JOIN proveedor p ON p.codproveedor=r.codproveedor WHERE p.Estado='A' and +$where");
						$result = mysqli_num_rows($query);
						if ($result > 0) {
							while ($data = mysqli_fetch_assoc($query)) { ?>
								<tr>
									<td><?php echo $data['nombre']; ?></td>
									<td><?php echo $data['proveedor']; ?></td>
									<td><?php echo $data['preciodiario']; ?></td>
									<td><?php echo $data['totaldejabas']; ?></td>
									<td><?php echo $data['pesototal']; ?></td>
									<td><?php echo $data['TotalDestare']; ?></td>
									<td><?php echo $data['PesoNeto']; ?></td>
									<td><?php echo $data['montoacobrar']; ?></td>
									<td><?php echo $data['fechadecreacion']; ?></td>
									<td><?php echo $data['Estado'];  ?></td>
									<?php if ($_SESSION['rol'] == 1) { ?>
									<td>
										<a href="editar_registrocuenta.php?id=<?php echo $data['nombre']; ?>" class="btn btn-success"><i class='fas fa-edit'></i> Editar</a>
										<form action="eliminar_registrocuenta.php?id=<?php echo $data['idregistro']; ?>" method="post" class="confirmar d-inline">
											<button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
										</form>
									</td>
									<?php } ?>
								</tr>
						<?php }
						} ?>
					</tbody>

				</table>
			</div>

		</div>
	</div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<?php include_once "includes/footer.php"; ?>
<?php include_once "registro_registrocuenta.php"; ?>