<?php include_once "includes/header.php";


?>

<!-- Begin Page Content -->
<div class="container-fluid">




	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Detalle de cuadre</h1>
	</div>
	<div>
		</select>
		<button id="btn_Reportecuadreyugoslabia" class="btn btn-primary"><i class="fas fa-search"></i>Ver detalle de pago pendiente yugoslabia</button>
        <button id="btn_Reportecuadrerocio" class="btn btn-primary"><i class="fas fa-search"></i>Ver detalle de pago pendiente Rocio</button>
	</div>
</div>
<div id="dialog-form-Reporte" title="Reporte" class="temporal_hide" style="display: none;">
	<div id="Contenedor-Reporte"></div>
	
		<table id="tb-Reportecuadreyugoslabia" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead class="thead-dark">
				<tr>
					<th></th>
					<th>ID</th>
				</tr>
			</thead>

			<tbody>
			</tbody>
		</table>
	</div>

    

    
<!-- /.container-fluid -->


<!-- End of Main Content -->


<?php include_once "includes/footer.php"; ?>
<?php include_once "registro_cuadre.php"; ?>
<script>
	$(document).ready(function() {

		var oListacuadre;
		var oListaRegistros;
		var oReporte;

		$(Load);

		function Load() {
			InitButtons();
			Listacuadre();
			load_MostrarReporte();


		}

		function InitButtons() {

			$('#Lista_cuadre').click(Listacuadre);
            $('#btn_Reportecuadreyugoslabia').click(MostrarRegistrosReporte);


		}


		function Listacuadre() {

			if (typeof oListacuadre === 'undefined') {
				ConstruirTablaListarRegistros();
				$('#table-Listacuadre').removeAttr('style');
			} else {
				oListacuadre.draw();
				$('#table-Listacuadre').removeAttr('style');
				$("#tb-Listarcuadre").dataTable().fnDestroy();
				ConstruirTablaListarRegistros();
			}
		}

		function ConstruirTablaListarRegistros() {
			var action = "Listacuadre";
			var fecha_de = $('#fecha_de').val();
			var fecha_a = $('#fecha_a').val();
			var cb_proveedor = $('#cb_proveedor').val();
			var cb_cliente = $('#cb_cliente').val();
			var errorAjax = '';
			oListacuadre = $('#tb-Listacuadre').DataTable({
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
				$("#tb-Reportecuadreyugoslabia").dataTable().fnDestroy();
				CargarReporte();
			}

			$("#Contenedor-Reporte").show();

			Estado_Reporte();
		}

		function CargarReporte() {

			var action = "Reportecuadreyugoslabia";
			var fecha_de = $('#fecha_de').val();
			var fecha_a = $('#fecha_a').val();
			var cb_proveedor = $('#cb_proveedor').val();
			var cb_cliente = $('#cb_cliente').val();
			var errorAjax = '';
			oReporte = $('#tb-Reportecuadreyugoslabia').DataTable({
				ajax: {
					url: 'controller/ReportecuadreyugoslabiaController.php',
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
						data: 'ID'
					},
					
					
				]

			});
			



		}
	});
</script>
