<section class="hero is-fullheight-with-navbar">
        <div class="hero-body">
            <div class="container">
                <div class="columns is-vcentered">
                    <div class="column is-6 login-image"></div>
                    <div class="column is-6">
                        <div class="login-form">
                            <h3 class="title is-3 has-text-centered is-uppercase">Iniciar Sesión</h3>
                            <form action="" method="POST" autocomplete="off">
                                <div class="field">
                                    <label class="label">Usuario</label>
                                    <div class="control has-icons-left has-icons-right">
                                        <input class="input" type="text" placeholder="Usuario" name="login_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Contraseña</label>
                                    <div class="control has-icons-left">
                                        <input class="input" type="password" placeholder="Contraseña" name="login_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <button type="submit" class="button is-info is-fullwidth">Iniciar sesión</button>
                                    </div>
                                </div>
                            </form>
                            <p class="has-text-centered mt-4">
                                <small>Para una mejor experiencia y por seguridad, te recomendamos tener instalada la última versión de este navegador:</small>
                            </p>
                            <div class="has-text-centered mt-2">
                                <img alt="Navegador recomendado" width="50" height="50" src="https://st2.depositphotos.com/1102480/7545/i/950/depositphotos_75454855-stock-photo-google-chrome-logo-printed-on.jpg">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
            if (navbarBurgers.length > 0) {
                navbarBurgers.forEach(el => {
                    el.addEventListener('click', () => {
                        const target = el.dataset.target;
                        const $target = document.getElementById(target);
                        el.classList.toggle('is-active');
                        $target.classList.toggle('is-active');
                    });
                });
            }
        });
    </script>
<?php
	if(isset($_POST['login_usuario']) && isset($_POST['login_clave'])){
		$insLogin->iniciarSesionControlador();
	}
?>