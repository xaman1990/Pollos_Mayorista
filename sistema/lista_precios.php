<?php include_once "includes/header.php";



$where = "r.Estado='A'";
$fecha_de = "";
$fecha_a = "";

if (!empty($_REQUEST['fecha_de']) || !empty($_REQUEST['fecha_a'])) {
	$fecha_de = $_REQUEST['fecha_de'];
	$fecha_a = $_REQUEST['fecha_a'];
	if ($fecha_de > $fecha_a) {
	} else if ($fecha_de == $fecha_a) {
		$where = " r.FechaCreacion LIKE '%$fecha_de%' and r.Estado='A'";
	} else {
		$f_de = date("Y-m-d", strtotime($fecha_de . "0 days"));
		$f_a =  date("Y-m-d", strtotime($fecha_a . "+ 1 days"));

		$where = " r.FechaCreacion BETWEEN '$f_de' AND '$f_a' and r.Estado='A'";
		$buscar = "fecha_de=$fecha_de&fecha_a=$fecha_a";
	}
} else if (empty($_REQUEST['fecha_de']) || empty($_REQUEST['fecha_a'])) {
	$where = "r.Estado='A'";
}

?>

<!-- Begin Page Content -->

<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Precio diario</h1>
		<button class="btn btn-info" data-toggle="modal" data-target="#modalAgregarPrecio" style="float:right">
			Nuevo Precio diario
		</button>

	</div>
	<div>
		<h5> buscar por fecha </h5>
		<form action="lista_precios.php" method="get" class="form_search_date">
			<label>DE: </label>
			<input type="date" name="fecha_de" id="fecha_de" value="<?php echo $fecha_de; ?>" required>
			<label> A </label>
			<input type="date" name="fecha_a" id="fecha_a" value="<?php echo $fecha_a; ?>" required>
			<button type="submit" class="btn_view"><i class="fas fa-search"></i></button>
		</form>
	</div>
	<br />
	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="table">
					<thead class="thead-dark">
						<tr>
							<th>id</th>
							<th>NombreProveedor</th>
							<th>Precio Compra</th>
							<th>Precio Venta</th>
							<th>Subida Interna</th>
							<th>Precio VentaF</th>
							<th>Fecha de Creacion</th>
							<th>Estado</th>
							<th>Fecha validacion</th>
							<?php if ($_SESSION['rol'] == 1) { ?>
							<th>ACCIONES</th>
							<?php }?>
						</tr>
					</thead>
					<tbody>
						<?php
						include "../conexion.php";

						$query = mysqli_query($conexion, "SELECT r.idprecio,  p.codproveedor , p.proveedor , r.preciocompra , r.precioVenta , r.SubidaInterna , r.PrecioVentaF , r.FechaCreacion , r.Estado,r.fechavalidacion FROM  precio r  INNER JOIN  proveedor p ON p.codproveedor= r.codproveedor WHERE r.estado='A' and + $where");
						$result = mysqli_num_rows($query);
						if ($result > 0) {
							while ($data = mysqli_fetch_assoc($query)) { ?>
								<tr>
									<td><?php echo $data['idprecio']; ?></td>
									<td><?php echo $data['proveedor']; ?></td>
									<td><?php echo $data['preciocompra']; ?></td>
									<td><?php echo $data['precioVenta']; ?></td>
									<td><?php echo $data['SubidaInterna']; ?></td>
									<td><?php echo $data['PrecioVentaF']; ?></td>
									<td><?php echo $data['FechaCreacion']; ?></td>
									<td><?php echo $data['Estado'];  ?></td>
									<td><?php echo $data['fechavalidacion']; ?></td>
									<?php if ($_SESSION['rol'] == 1) { ?>
									<td>
										<a href="editar_precios.php?id=<?php echo $data['idprecio']; ?>" class="btn btn-success"><i class='fas fa-edit'></i> Editar</a>
										<form action="eliminar_precios.php?id=<?php echo $data['idprecio']; ?>" method="post" class="confirmar d-inline">
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
<?php include_once "registro_precios.php"; ?>