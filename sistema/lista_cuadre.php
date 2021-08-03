<?php include_once "includes/header.php";


?>

<!-- Begin Page Content -->
<div class="container-fluid">




	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Registro de cuadre</h1>
		<button class="btn btn-info" data-toggle="modal" data-target="#modalAgregarcuadre" style="float:right">
			Nuevo cuadre
		</button>

	</div>
	<div>


		<label>DE: </label>
		<input type="date" name="fecha_de" id="fecha_de" value="<?php echo $fecha_de; ?>">
		<label> A </label>
		<input type="date" name="fecha_a" id="fecha_a" value="<?php echo $fecha_a; ?>">


		<label for="nombre">Proveedor</label>
		<?php
		include "../conexion.php";
		$query_proveedor = mysqli_query($conexion, "SELECT * FROM proveedor where estado='A' ORDER BY proveedor ASC");
		$resultado_proveedor = mysqli_num_rows($query_proveedor);
		?>

		<select id="cb_proveedor" name="cb_proveedor">
			<option value="">Ninguno</option>
			<?php
			if ($resultado_proveedor > 0) {
				while ($proveedor = mysqli_fetch_array($query_proveedor)) {
					// code...
					if ($resultado_tipoproveedor > 0) {
			?>
						<option value="<?php echo $proveedor["codproveedor"]; ?>"><?php echo $proveedor["proveedor"]; ?></option>
					<?php
					} else {
					?>
						<option value="<?php echo $proveedor["codproveedor"]; ?>"><?php echo $proveedor["proveedor"]; ?></option>
			<?php
					}
				}
			}
			?>
		</select>
		<button id="Listar_cuadre" class="btn btn-info"><i class="fas fa-search"></i>Listar</button>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div id="table-Listarcuadre" style="display: none;" class="table-responsive">
				<div id="list-Listarcuadre" style="width: 100%;">
					<table id="tb-Listarcuadre" class="table table-striped table-bordered" cellspacing="0" width="100%">
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
<?php include_once "registro_cuadre.php"; ?>
<script>
	$(document).ready(function() {

		var oListarcuadre;
		var oListaRegistros;
		$(Load);

		function Load() {
			InitButtons();
			Listarcuadre();

		}

		function InitButtons() {

			$('#Listar_cuadre').click(Listarcuadre);


		}


		function Listarcuadre() {

			if (typeof oListarcuadre === 'undefined') {
				ConstruirTablaListarRegistros();
				$('#table-Listarcuadre').removeAttr('style');
			} else {
				oListarcuadre.draw();
				$('#table-Listarcuadre').removeAttr('style');
				$("#tb-Listarcuadre").dataTable().fnDestroy();
				ConstruirTablaListarRegistros();
			}
		}

		function ConstruirTablaListarRegistros() {
			var action = "Listarcuadre";
			var fecha_de = $('#fecha_de').val();
			var fecha_a = $('#fecha_a').val();
			var cb_proveedor = $('#cb_proveedor').val();
			var cb_cliente = $('#cb_cliente').val();
			var errorAjax = '';
			oListarCuentas = $('#tb-Listarcuadre').DataTable({
				ajax: {
					url: 'controller/cuadreController.php',
					type: "POST",
					dataType: "json",
					destroy: true,
					error: errorAjax,
					data: {
						//parametros
						action: action,
						fecha_de: fecha_de,
						fecha_a: fecha_a,
						cb_proveedor: cb_proveedor,
						cb_cliente: cb_cliente
					},

				},
				success: function(response) {
					if (response == 0) {

					} else {
						var data = JSON.parse(response);
					}
					//var info = JSON.parse(response);
					//console.log(info); console.log("HERE : ", response)

				},
				rowCallback: function(row, data, index) {

					
					$('td', row).eq(7).html('<a href="editar_registrocuadre.php?idcuadre=' + data.idcuadre + '&idpagoproveedor=' + data.idcuadre + '" class="btn btn-success"><i class="fas fa-edit"></i> Editar</a><form action="eliminar_registrocuadre.php?id=' + data.idcuadre + '" method="post" class="confirmar d-inline"><button class="btn btn-danger" type="submit"><i class="fas fa-trash-alt"></i> </button></form>');



				},
				columns: [{

						data: ''
					},
					{
						data: ''
					},
					{
						data: ''
					},
					{
						data: ''
					},
					{
						data: ''
					},
					{
						data: ''
					},

					{
						data: ''
					},
					{
						data: null
					}
				]

			});



		}



	});
</script>