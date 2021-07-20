<?php include_once "includes/header.php";



$where = "r.estado='A'";
$fecha_de = "";
$fecha_a = "";

if (!empty($_REQUEST['fecha_de']) || !empty($_REQUEST['fecha_a'])) {
	$fecha_de = $_REQUEST['fecha_de'];
	$fecha_a = $_REQUEST['fecha_a'];
	if ($fecha_de > $fecha_a) {
	} else if ($fecha_de == $fecha_a) {
		$where = " r.fechadecreacion LIKE '%$fecha_de%' and r.estado='A'";
	} else {
		$f_de = date("Y-m-d", strtotime($fecha_de . "0 days"));
		$f_a =  date("Y-m-d", strtotime($fecha_a . "+ 1 days"));

		$where = " r.fechadecreacion BETWEEN '$f_de' AND '$f_a' and r.estado='A'";
		$buscar = "fecha_de=$fecha_de&fecha_a=$fecha_a";
	}
} else if (empty($_REQUEST['fecha_de']) || empty($_REQUEST['fecha_a'])) {
	$where = "r.estado='A'";
}

?>



<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Proveedores</h1>
		<button class="btn btn-info" data-toggle="modal" data-target="#modalAgregarProveedor" style="float:right">
			Nuevo Proveedor
		</button>

	</div>
	<br />
	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
					<div class="table-responsive"  style="overflow-x: hidden;">
				<table class="table table-striped table-bordered" id="table">
					<thead class="thead-dark">
						<tr>
							<th>ID</th>
							<th>Tipo de proveedor</th>
							<th>Nombre de proveedor</th>
							<th>Peso de jaba	</th>
							<th>Fecha creacion</th>
							<th>Estado</th>
							<?php if ($_SESSION['rol'] == 1) { ?>
							<th>ACCIONES</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php
						include "../conexion.php";

						$query = mysqli_query($conexion, " SELECT  r.codproveedor ,  p.tipoproveedor, r.proveedor , r.pesojaba, r.fechadecreacion , r.Estado FROM proveedor r Left JOIN tipoproveedor p ON r.tipoproveedor=p.idtipoproveedor WHERE + $where"  );
						$result = mysqli_num_rows($query);
						if ($result > 0) {
							while ($data = mysqli_fetch_assoc($query)) { ?>
								<tr>
									<td><?php echo $data['codproveedor']; ?></td>
									<td><?php echo $data['tipoproveedor']; ?></td>
									<td><?php echo $data['proveedor']; ?></td>
									<td><?php echo $data['pesojaba']; ?></td>
									<td><?php echo $data['fechadecreacion']; ?></td>
									<td><?php echo $data['Estado']; ?></td>
									<?php if ($_SESSION['rol'] == 1) { ?>
									<td>
										<a href="editar_proveedor.php?id=<?php echo $data['codproveedor']; ?>" class="btn btn-success"><i class='fas fa-edit'></i> Editar</a>
										<form action="eliminar_proveedor.php?id=<?php echo $data['codproveedor']; ?>" method="post" class="confirmar d-inline">
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
<?php include_once "registro_proveedor.php"; ?>
