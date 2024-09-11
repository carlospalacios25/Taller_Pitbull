<div class="container is-fluid mb-6">
	<h1 class="title">Proveedor</h1>
	<h2 class="subtitle">Listado de Proveedores</h2>
</div>
<div class="container pb-6 pt-6">

<!--	<div class="container pb-6 pt-6">
		<a href="<?php echo APP_URL; ?>app/views/fpdf/PruebaVP.php" target="_blank" class="button is-primary is-outlined">Generar Reporte General</a>
	</div>-->

	<?php
		use app\controllers\supplierController;

		$insUsuario = new supplierController();

		echo $insUsuario->listarProveedorControlador($url[1],5,$url[0],"");
	?>
	
</div>