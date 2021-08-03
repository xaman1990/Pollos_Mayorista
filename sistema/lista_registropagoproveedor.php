<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Lista de Registro de Pagos de Proveedores</h1>
		<?php if ($_SESSION['rol'] == 1) { ?>
		<a href="registro_registropagoproveedor.php" class="btn btn-primary">Nuevo Registro de Pago Proveedor</a>
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
							<th>Precio Compra Diario</th>
							<th>Total Jabas</th>
                            <th>Monto Total</th>
                            <th>Monto depositado</th>
							<th>Fecha de pedido</th>
							<?php if ($_SESSION['rol'] == 1) { ?>
							<th>ACCIONES</th>
							<?php }?>
						</tr>
					</thead>
					<tbody>
						<?php
						include "../conexion.php";

						$query = mysqli_query($conexion, "select pre.idprecio ,pro.proveedor,pre.preciocompra,sum(rc.totaldejabas) as totaldejabas,sum(rc.PesoNeto*pre.preciocompra) as MontoTotal,'' as Monto_Depositado,rc.fechapedido 
						from registrocuentas rc
						left join precio pre on rc.codproveedor=pre.codproveedor and rc.fechapedido=pre.fechavalidacion and pre.Estado='A'
						left join proveedor pro on pro.codproveedor=rc.codproveedor
						left join cliente cli on rc.idcliente=cli.idcliente
						where pre.idprecio IS not null 
						group by pro.proveedor,pre.preciocompra,rc.fechapedido
						order by fechapedido DESC");
						$result = mysqli_num_rows($query);
						if ($result > 0) {
							while ($data = mysqli_fetch_assoc($query)) { ?>
								<tr>
								<td><?php echo $data['idprecio']; ?></td>
									<td><?php echo $data['proveedor']; ?></td>
									<td><?php echo $data['preciocompra']; ?></td>
									<td><?php echo $data['totaldejabas']; ?></td>
                                    <td><?php echo $data['MontoTotal']; ?></td>
                                    <td><?php echo $data['Monto_Depositado']; ?></td>
									<td><?php echo $data['fechapedido']; ?></td>
									<?php if ($_SESSION['rol'] == 1) { ?>
									<td>
										<a href="editar_registropagoproveedor.php?id=<?php echo $data['idpagoproveedor']; ?>" class="btn btn-success"><i class='fas fa-edit'></i> Editar</a>
										<form action="eliminar_registropagoproveedor.php?id=<?php echo $data['idpagoproveedor']; ?>" method="post" class="confirmar d-inline">
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