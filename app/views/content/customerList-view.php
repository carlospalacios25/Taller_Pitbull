<div class="container is-fluid mb-6">
	<h1 class="title">Clientes Registrados</h1>
	<h2 class="subtitle">Listado de Clientes</h2>
</div>
<div class="container pb-6 pt-6">

	<div class="form-rest mb-6 mt-6"></div>

	<?php
		use app\controllers\customerController;

		$insUsuario = new customerController();

		echo $insUsuario->listarClienteControlador($url[1],5,$url[0],"");
	?>
	
</div>