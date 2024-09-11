<div class="container is-fluid mb-6">
	<?php 

		$id=$insLogin->limpiarCadena($url[1]);

		if($id==$_SESSION['id']){ 
	?>
	<h1 class="title">Cargo</h1>
	<h2 class="subtitle">Actualizar Cargo</h2>
	<?php }else{ ?>
	<h1 class="title">Cargo</h1>
	<h2 class="subtitle">Actualizar Cargo</h2>
	<?php } ?>
</div>
<div class="container pb-6 pt-6">
	<?php
	
		include "./app/views/inc/btn_back.php";

		$datos=$insLogin->seleccionarDatos("Unico","cargos","id_cargos",$id);

		if($datos->rowCount()==1){
			$datos=$datos->fetch();
	?>
	<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/cargoAjax.php" method="POST" autocomplete="off" >

		<input type="hidden" name="Modulo_Tipo_Cargo" value="actualizar">
		<input type="hidden" name="id_cargos" value="<?php echo $datos['id_cargos']; ?>">

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Tipo Proveedor</label>
				  	<input class="input" type="text" name="tipo_cargo" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="50" value="<?php echo $datos['tipo_cargo']; ?>" required >
				</div>
		  	</div>
		  	<div class="column">

		  	</div>
		</div>
			<p class="has-text-centered">
			Para poder actualizar los datos de tipo proveedor por favor ingrese su USUARIO y CLAVE con la que ha iniciado sesión
		</p>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Usuario</label>
				  	<input class="input" type="text" name="administrador_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Clave</label>
				  	<input class="input" type="password" name="administrador_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required >
				</div>
		  	</div>
		</div>
		<p class="has-text-centered">
			<button type="submit" class="button is-success is-rounded">Actualizar</button>
		</p>
	</form>
	<?php
		}else{
			include "./app/views/inc/error_alert.php";
		}
	?>
</div>
