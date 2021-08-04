<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

	<!-- Sidebar - Brand -->
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
		<div class="sidebar-brand-text mx-3">Distribuidora Santa Beatriz</div>
	</a>

	<!-- Divider -->
	<hr class="sidebar-divider my-0">

	<!-- Divider -->
	<hr class="sidebar-divider">

	<!-- Heading -->
	<div class="sidebar-heading">
		Interface
	</div>

	<!-- Nav Item - Pages Collapse Menu -->
	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProveedor" aria-expanded="true" aria-controls="collapseUtilities">
			<i class="fas fa-hospital"></i>
			<span>Mantenimiento</span>
		</a>
		<div id="collapseProveedor" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<a class="collapse-item" href="lista_proveedor.php">Proveedores</a>
				<a class="collapse-item" href="lista_cliente.php">Clientes</a>
				<a class="collapse-item" href="lista_usuarios.php">Usuarios</a>
				<a class="collapse-item" href="lista_precios.php">Precio diario</a>



			</div>
		</div>
	</li>
	<!-- Nav Item - Pages Collapse Menu -->

		<!-- Nav Item - Pages Collapse Menu -->
	<!-- Nav Item - Pages Collapse Menu -->
	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePedido" aria-expanded="true" aria-controls="collapseUtilities">
			<i class="fas fa-fw fa-wrench"></i>
			<span>Registro de Pedido</span>
		</a>
		<div id="collapsePedido" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
							<a class="collapse-item" href="lista_pedido.php">Lista de Pedidos</a>
			</div>
		</div>
	</li>
	<!-- Nav Item - Pages Collapse Menu -->
	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCuentas" aria-expanded="true" aria-controls="collapseUtilities">
			<i class="fas fa-fw fa-wrench"></i>
			<span>Registro de Cuentas</span>
		</a>
		<div id="collapseCuentas" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
			
				<a class="collapse-item" href="lista_registrocuenta.php">Lista de Cuentas</a>
			</div>
		</div>
	</li>
	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePagos" aria-expanded="true" aria-controls="collapseUtilities">
			<i class="fas fa-fw fa-wrench"></i>
			<span>Registro de  pagos</span>
		</a>
		<div id="collapsePagos" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
			
				<a class="collapse-item" href="lista_registropagos.php">Lista  de pagos</a>
			</div>
		</div>
	</li>
	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsepagoproveedor" aria-expanded="true" aria-controls="collapseUtilities">
			<i class="fas fa-fw fa-wrench"></i>
			<span> Pagos de proveedores</span>
		</a>
		<div id="collapsepagoproveedor" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
			
				<a class="collapse-item" href="lista_registropagoproveedor.php">Lista de  pagos </a>
			</div>
		</div>
	</li>
	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
			<i class="fas fa-fw fa-wrench"></i>
			<span>Registro Cuadre</span>
		</a>
		<div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<a class="collapse-item" href="lista_cuadre.php">Cuadre</a>
			</div>
		</div>
	</li>


	<!-- Nav Item - Productos Collapse Menu -->
	
<!-- Nav Item - Productos Collapse Menu -->
	
	

	
<!-- Nav Item - Productos Collapse Menu -->
	<!-- Nav Item - Utilities Collapse Menu -->
	<?php if ($_SESSION['rol'] == 1) { ?>
		<!-- Nav Item - Usuarios Collapse Menu -->
		
	<?php } ?>

</ul>