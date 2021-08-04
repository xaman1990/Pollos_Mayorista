<?php include_once "includes/header.php";


?>

<!-- Begin Page Content -->
<div class="container-fluid">




	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Precio diario</h1>
		<button class="btn btn-info" data-toggle="modal" data-target="#modalAgregarprecio" style="float:right">
			Nuevo Precio Diario
		</button>

	</div>
	<div>
		<h5> buscar por fecha </h5>
		<form action="lista_precios.php" method="get" class="form_search_date">
			<label>DE: </label>
			<input type="text" name="fecha_de"  class="datepicker"  id="fecha_de" value="<?php echo $fecha_de; ?>" required>
			<label> A </label>
			<input type="text" name="fecha_a" class="datepicker"  id="fecha_a" value="<?php echo $fecha_a; ?>" required>
			<button type="submit" class="btn_view"><i class="fas fa-search"></i></button>
		</form>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div id="table-Listarprecios" style="display: none;" class="table-responsive">
				<div id="list-Listarprecios" style="width: 100%;">
					<table id="tb-Listarprecios" class="table table-striped table-bordered" cellspacing="0" width="100%">
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
						</tbody>
					</table>
				</div>
			</div>





		</div>
	</div>


</div>


<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<?php include_once "includes/footer.php"; ?>
<?php include_once "registro_precios.php"; ?>
<script>
	$(document).ready(function() {

		var oListarprecios;
		var oListaRegistros;
		$(Load);

		function Load() {
			InitButtons();
			Listarprecios();

		}

		function InitButtons() {

			$('#Listar_precios').click(Listarprecios);


		}


		function Listarprecios() {

			if (typeof oListarprecios === 'undefined') {
				ConstruirTablaListarRegistros();
				$('#table-Listarprecios').removeAttr('style');
			} else {
				oListarprecios.draw();
				$('#table-Listarprecios').removeAttr('style');
				$("#tb-Listarprecios").dataTable().fnDestroy();
				ConstruirTablaListarRegistros();
			}
		}

		function ConstruirTablaListarRegistros() {
			var action = "Listarprecios";
			var fecha_de = $('#fecha_de').val();
			var fecha_a = $('#fecha_a').val();
			var errorAjax = '';
			oListarprecios = $('#tb-Listarprecios').DataTable({
				ajax: {
					url: 'controller/preciosController.php',
					type: "POST",
					dataType: "json",
					destroy: true,
					error: errorAjax,
					data: {
						//parametrosaaa
						action: action,
						fecha_de: fecha_de,
						fecha_a: fecha_a,
					},

				},
				success: function(response) {
					if (response == 0) {

					} else {
						var data = JSON.parse(response);
					}
					

				},
				rowCallback: function(row, data, index) {
					
					
						$('td', row).eq(9).html('<a href="editar_precios.php?id='+ data.idprecio+'" class="btn btn-success"><i class="fas fa-edit"></i> Editar</a><form action="eliminar_precios.php?id='+data.idprecio+'" method="post" class="confirmar d-inline"><button class="btn btn-danger" type="submit"><i class="fas fa-trash-alt"></i> </button></form>');
					
					

				},
				order: [[ 0, "desc" ]],
				columns: [{
						data: 'idprecio'
					},
					{
						data: 'proveedor'
					},
					{
						data: 'preciocompra'
					},
					{
						data: 'precioVenta'
					},
					{
						data: 'SubidaInterna'
					},
					{
						data: 'PrecioVentaF'
					},
					{
						data: 'FechaCreacion'
					},
					{
						data: 'fechavalidacion'
					},
					{
						data: 'Estado'
					},
					{
						data: null
					}
				]

			});



		}



	});
</script>