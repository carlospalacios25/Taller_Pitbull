<div class="main-container">

    <form class="box login" action="" method="POST" autocomplete="off" >
		<h5 class="title is-5 has-text-centered is-uppercase">LOGIN</h5>

		<div class="field">
			<label class="label">Usuario</label>
			<p class="control has-icons-left has-icons-right">
				<input class="input" type="text" placeholder="Usuario" name="login_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
				<span class="icon is-small is-left">
					<i class="fas fa-envelope"></i>
				</span>
				<span class="icon is-small is-right">
					<i class="fas fa-check"></i>
				</span>
			</p>
		</div>
		<div class="field">
			<label class="label">Contraseña</label>
			<p class="control has-icons-left">
				<input class="input" type="password" placeholder="Contraseña" name="login_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
			<span class="icon is-small is-left">
				<i class="fas fa-lock"></i>
			</span>
			</p>
		</div>
		<p class="has-text-centered mb-4 mt-3">
			<button type="submit" class="button is-info is-rounded">Iniciar sesion</button>
		</p>

		<label class="centerText-label"><h7>Para una mejor experiencia y por seguridad, te recomendamos tener instalada la última versión de este navegador:</h7></label>
		<div class="contenedor">
            <img alt="Bulma" width="50" height="50" src="<?php echo APP_URL; ?>app/views/img/Navegador.png">
        </div>
	</form>
</div>

<?php
	if(isset($_POST['login_usuario']) && isset($_POST['login_clave'])){
		$insLogin->iniciarSesionControlador();
	}
?>