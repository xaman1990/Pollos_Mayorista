<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Lista de Precios Diarios</h1>
		<?php if ($_SESSION['rol'] == 1) { ?>
		<a href="registro_precios.php" class="btn btn-primary">Nuevo Precio</a>
		<?php } ?>
	</div>

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

						$query = mysqli_query($conexion, "SELECT r.idprecio,  p.codproveedor , p.proveedor , r.preciocompra , r.precioVenta , r.SubidaInterna , r.PrecioVentaF , r.FechaCreacion , r.Estado,r.fechavalidacion FROM proveedor p INNER JOIN precio r ON p.codproveedor= r.codproveedor");
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