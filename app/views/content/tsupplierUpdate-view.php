<div class="container is-fluid mb-6">
	<?php 

		$id=$insLogin->limpiarCadena($url[1]);

		if($id == $_SESSION['id']){ 
	?>
		<h1 class="title">Actualizar Tipo Proveedor</h1>
	<?php }else{ ?>
		<h1 class="title">Actualizar Tipo Proveedor</h1>
	<?php } ?>
</div>
<div class="container pb-6 pt-6">
	<?php
	
		include "./app/views/inc/btn_back.php";

		$datos=$insLogin->seleccionarDatos("Unico","tipo_proveedor","id_tipo_proveedor",$id);

		if($datos->rowCount()==1){
			$datos=$datos->fetch();
	?>
	<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/tproveedorAjax.php" method="POST" autocomplete="off" >

		<input type="hidden" name="Modulo_Tipo_Proveedor" value="actualizar">
		<input type="hidden" name="id_tipo_proveedor" value="<?php echo $datos['id_tipo_proveedor']; ?>">

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Tipo Proveedor</label>
				  	<input class="input" type="text" name="tipo_proveedor" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="50" value="<?php echo $datos['tipo_proveedor']; ?>" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Descripcion</label>
				  	<input class="input" type="text" name="descripcion"  maxlength="70" value="<?php echo $datos['descripcion']; ?>" required >
				</div>
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