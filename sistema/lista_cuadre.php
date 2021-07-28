<?php include_once "includes/header.php"; 

$where = "Estado='A'";
$fecha_de = "";
$fecha_a = "";

if (!empty($_REQUEST['fecha_de']) || !empty($_REQUEST['fecha_a'])) {
	$fecha_de = $_REQUEST['fecha_de'];
	$fecha_a = $_REQUEST['fecha_a'];
	if ($fecha_de > $fecha_a) {
	} else if ($fecha_de == $fecha_a) {
		$where = " fechapedido=DATE_FORMAT('$fecha_de', '%m/%d/%Y') and Estado='A'";
	} else {
		$f_de = date("Y-m-d", strtotime($fecha_de . "0 days"));
		$f_a =  date("Y-m-d", strtotime($fecha_a . "+ 1 days"));

		$where = " fechapedido BETWEEN DATE_FORMAT('$f_de', '%m/%d/%Y') AND DATE_FORMAT('$f_a', '%m/%d/%Y') and Estado='A'";
		$buscar = "fecha_de=$fecha_de&fecha_a=$fecha_a";
	}
} else if (empty($_REQUEST['fecha_de']) || empty($_REQUEST['fecha_a'])) {
	$where = "Estado='A'";
}




?>

<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Registro de Cuadre</h1>
		<button class="btn btn-info" data-toggle="modal" data-target="#modalAgregarcuadre" style="float:right">
		Nuevo cuadre
		</button>
	</div>
	<div>
		<h5> buscar por fecha </h5>
		<form action="lista_cuadre.php" method="get" class="form_search_date">
			<label>DE: </label>
			<input type="date" name="fecha_de" id="fecha_de" value="<?php echo $fecha_de; ?>" required>
			<label> A </label>
			<input type="date" name="fecha_a" id="fecha_a" value="<?php echo $fecha_a; ?>" required>
			<button type="submit" class="btn_view"><i class="fas fa-search"></i></button>
		</form>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="table">
					<thead class="thead-dark">
						<tr>
							<th>ID</th>
							<th>Fechapedido</th>
							<th>Dudas Historico</th>
							<th>Dep AF Y</th>
							<th>Monto depositado</th>
							<th>Estado</th>
							<?php if ($_SESSION['rol'] == 1) { ?>
							<th>ACCIONES</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php
						include "../conexion.php";

						$query = mysqli_query($conexion, "SELECT * FROM cuadre");
						$result = mysqli_num_rows($query);
						if ($result > 0) {
							while ($data = mysqli_fetch_assoc($query)) { ?>
								<tr>
									<td><?php echo $data['idcuadre ']; ?></td>
									<td><?php echo $data['fechapedido']; ?></td>
									<td><?php echo $data['dudashistorico']; ?></td>
									<td><?php echo $data['depafy']; ?></td>
									<td><?php echo $data['Montodepositado']; ?></td>
									<td><?php echo $data['Estado']; ?></td>
										<?php if ($_SESSION['rol'] == 1) { ?>
									<td>
										<a href="registro_cuadre.php?id=<?php echo $data['idcuadre']; ?>" class="btn btn-primary"><i class='fas fa-audio-description'></i></a>

										<a href="editar_cuadre.php?id=<?php echo $data['idcuadre']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>

										<form action="eliminar_cuadre.php?id=<?php echo $data['idcuadre']; ?>" method="post" class="confirmar d-inline">
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
<?php include_once "registro_cuadre.php"; ?>