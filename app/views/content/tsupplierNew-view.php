<div class="container is-fluid mb-6">
	<h1 class="title">PROVEEDOR</h1>
	<h2 class="subtitle">Nuevo tipo proveedor</h2>
</div>

<div class="container pb-6 pt-6">

	<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/tproveedorAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data" >

		<input type="hidden" name="Modulo_Tipo_Proveedor" value="registrar">

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Tipo Proveedor</label>
				  	<input class="input" type="text" name="tipo_proveedor" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="50" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Descripcion del tipo</label>
				  	<input class="input" type="text" name="descripcion" maxlength="70" required >
				</div>
		  	</div>
		</div>
		<p class="has-text-centered">
			<button type="reset" class="button is-link is-light is-rounded">Limpiar</button>
			<button type="submit" class="button is-info is-rounded">Guardar</button>
		</p>
			<div class="container is-fluid mb-6">
			<h6 class="title">Lista de tipo Proveedor</h6>
			</div>
			<div class="container pb-6 pt-6">

			<div class="form-rest mb-6 mt-6"></div>

			<?php
			use app\controllers\tsupplierController;

			$insUsuario = new tsupplierController();

			echo $insUsuario->listarTproveedorControlador($url[1],5,$url[0],"");
			?>

			</div>
	</form>
</div>