<?php include_once "includes/header.php";


?>

<!-- Begin Page Content -->
<div class="container-fluid">




	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Registro Cuenta</h1>
		<button class="btn btn-info" data-toggle="modal" data-target="#modalAgregarcuenta" style="float:right">
			Nuevo Cuenta
		</button>

	</div>
	<div>


		<label>DE: </label>
		<input type="text" class="datepicker" name="fecha_de" id="fecha_de" >
		<label> A </label>
		<input type="text" class="datepicker" name="fecha_a" id="fecha_a" >


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

		<label for="nombre">Cliente</label>
		<?php
		include "../conexion.php";
		$query_cliente = mysqli_query($conexion, "SELECT idcliente, nombre FROM cliente where estado='A' ORDER BY nombre ASC");
		$resultado_cliente = mysqli_num_rows($query_cliente);
		mysqli_close($conexion);
		?>
		<select id="cb_cliente" name="cb_cliente">
			<option value="">Ninguno</option>
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


		<button id="Listar_Cuentas" class="btn btn-info"><i class="fas fa-search"></i>Listar</button>
		<button id="btn_Reporte" class="btn btn-primary"><i class="fas fa-search"></i>Reporte cuentas</button>

	</div>
	<div class="row">
		<div class="col-lg-12">
			<div id="table-ListarCuentas" style="display: none;" class="table-responsive">
				<div id="list-ListarCuentas" style="width: 100%;">
					<table id="tb-ListarCuentas" class="table table-striped table-bordered" cellspacing="0" width="100%">
						<thead class="thead-dark">
							<tr>
								<th>Cliente</th>
								<th>Proveedor</th>
								<th>Precio Diario</th>
								<th>Total Jaba</th>
								<th>Peso Total</th>
								<th>Total Destare</th>
								<th>Peso Neto</th>
								<th>Monto a cobrar</th>
								<th>Fecha de pedido</th>
								<th>Estado</th>
								<th>Acciones</th>
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
<div id="dialog-form-Reporte" title="Reporte" class="temporal_hide" style="display: none;">
	<div id="Contenedor-Reporte"></div>
	
		<table id="tb-Reportecuenta" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead class="thead-dark">
				<tr>
					<th></th>
					<th>Proveedor</th>
					<th>Total K Bruto</th>
					<th>Total Tara</th>
					<th>Total Kilo Neto</th>
					<th>Total importe vendido</th>
				</tr>
			</thead>

			<tbody>
			</tbody>
		</table>
	</div>
</div>

<!-- /.container-fluid -->

<!-- End of Main Content -->


<?php include_once "includes/footer.php"; ?>
<?php include_once "registro_registrocuenta.php"; ?>
<script>
	$(document).ready(function() {

		var oListarCuentas;
		var oListaRegistros;
		var oReporte;
		$(Load);

		function Load() {
			InitButtons();
			ListarCuentas();
            load_MostrarReporte();
		}

		function InitButtons() {

			$('#Listar_Cuentas').click(ListarCuentas);
            $('#btn_Reporte').click(MostrarRegistrosReporte);

		}


		function ListarCuentas() {

			if (typeof oListarCuentas === 'undefined') {
				ConstruirTablaListarRegistros();
				$('#table-ListarCuentas').removeAttr('style');
			} else {
				oListarCuentas.draw();
				$('#table-ListarCuentas').removeAttr('style');
				$("#tb-ListarCuentas").dataTable().fnDestroy();
				ConstruirTablaListarRegistros();
			}
		}

		function ConstruirTablaListarRegistros() {
			var action = "ListarCuentas";
			var fecha_de = $('#fecha_de').val();
			var fecha_a = $('#fecha_a').val();
			var cb_proveedor = $('#cb_proveedor').val();
			var cb_cliente = $('#cb_cliente').val();
			var errorAjax = '';
			oListarCuentas = $('#tb-ListarCuentas').DataTable({
				ajax: {
					url: 'controller/cuentasController.php',
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

					
					$('td', row).eq(10).html('<a href="editar_registrocuenta.php?idcuenta=' + data.idregistro + '&idpedido=' + data.idpedido + '" class="btn btn-success"><i class="fas fa-edit"></i> Registrar</a><form action="eliminar_registrocuenta.php?id=' + data.idregistro + '" method="post" class="confirmar d-inline"><button class="btn btn-danger" type="submit"><i class="fas fa-trash-alt"></i> </button></form>');



				},
				columns: [{
						data: 'nombre'
					},
					{
						data: 'proveedor'
					},
					{
						data: 'preciodiario'
					},
					{
						data: 'totaldejabas'
					},
					{
						data: 'pesototal'
					},
					{
						data: 'TotalDestare'
					},
					{
						data: 'PesoNeto'
					},
					{
						data: 'montoacobrar'
					},
					{
						data: 'fechapedido'
					},
					{
						data: 'EstadoFlujo'
					},
					{
						data: null
					}
				]

			});

		}

		function load_MostrarReporte() {
			LoadPoputReporte();
			CargarReporte();
			
		}

		function LoadPoputReporte() {
			$("#dialog-form-Reporte").dialog({
				autoOpen: false,
				height: 'auto',
				width: 'auto',
				modal: false,
				resizable: false,
				position: 'right top'

			});
		}

		function Estado_Reporte() {
			$("#load_Reporte").hide();
			$("#dialog-form-Reporte").dialog("open");
		}

		function MostrarRegistrosReporte() {
			if (typeof oReporte === 'undefined') {
				CargarReporte();
				$('#Contenedor-Reporte').removeAttr('style');
			} else {
				oReporte.draw();
				$('#Contenedor-Reporte').removeAttr('style');
				$("#tb-Reportecuenta").dataTable().fnDestroy();
				CargarReporte();
			}

			$("#Contenedor-Reporte").show();

			Estado_Reporte();
		}

		function CargarReporte() {

			var action = "Reportecuenta";
			var fecha_de = $('#fecha_de').val();
			var fecha_a = $('#fecha_a').val();
			var cb_proveedor = $('#cb_proveedor').val();
			var cb_cliente = $('#cb_cliente').val();
			var errorAjax = '';
			oReporte = $('#tb-Reportecuenta').DataTable({
				ajax: {
					url: 'controller/cuentasController.php',
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
				},

				order: [
					[0, "desc"]
				],
				columns: [{
						data: 'proveedor'
					},
					{
						data: 'pesototal'
					},
					{
						data: 'TotalDestare'
					},
					{
						data: 'PesoNeto'
					},
					{
						data: 'Totalimportevendido'
					}
					
				]

			});
			



		}
	});
</script>
