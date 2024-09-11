<div class="container is-fluid mb-6">
	<h1 class="title">CARGO</h1>
	<h2 class="subtitle">Nuevo Cargo</h2>
</div>

<div class="container pb-6 pt-6">

	<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/cargoAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data" >

		<input type="hidden" name="Modulo_Tipo_Cargo" value="registrar">

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Cargo</label>
				  	<input class="input" type="text" name="tipo_cargo" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="50" required >
				</div>
		  	</div>
		  	<div class="column">

		  	</div>
		</div>
		<p class="has-text-centered">
			<button type="reset" class="button is-link is-light is-rounded">Limpiar</button>
			<button type="submit" class="button is-info is-rounded">Guardar</button>
		</p>
	</form>

	<div class="container is-fluid mb-6">
        <h6 class="title">Listado de cargos</h6>
    	</div>
		<div class="container pb-6 pt-6">

		<?php
			use app\controllers\postController;

			$insUsuario = new postController();

			echo $insUsuario->listarPostControlador($url[1],5,$url[0],"");
		?>

		</div>
</div>