<nav class="navbar" role="navigation" aria-label="main navigation">
<div class="navbar-brand">
      <!--  <a class="navbar-item" href="<?php echo APP_URL; ?>#/">
            <img src="<?php echo APP_URL; ?>app/views/img/Logo_Inicio.png" alt="Bulma" width="100" height="100">
        </a>-->
        <span class="icon-text">
            <span class="icon">
               <i class="fas fa-home"></i>
            </span>
        </span>
        <div class="navbar-burger" data-target="navbarExampleTransparentExample">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start">
            <a class="navbar-item" href="<?php echo APP_URL; ?>customerNew/" >
                Registrarme 
            </a>
            </div>
            <div class="navbar-start">
            <a class="navbar-item" href="<?php echo APP_URL; ?>informationshop/" >
                Informacion taller 
            </a>
            </div>
            </div>

            <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                <a class="button is-primary" href="<?php echo APP_URL; ?>login/">
                    <strong>Login</strong>
                </a>
                </div>
            </div>
            </div>
    </div>
</nav>