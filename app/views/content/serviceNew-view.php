<div class="container is-fluid mb-6">
	<h1 class="title">Nuevo Servicio</h1>
</div>

<div class="container pb-6 pt-6">
<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/serviceAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">

    <input type="hidden" name="Modulo_Servicio" value="registrar">

    <div class="columns">
        <div class="column">
            <div class="control">
                <label>Ingresa Su Documento</label>
                <input class="input" type="number" name="cedula_cliente" pattern="[0-9]{3,40}" maxlength="16" required>
            </div>
        </div>
        <div class="column">
            <div class="control">
                <label>Especificacion Del Mantenimiento</label>
                <input class="input" type="text" name="observaciones" maxlength="1000" required>
            </div>
        </div>
    </div>
    <p class="has-text-centered">
        <button type="reset" class="button is-danger is-outlined">Limpiar</button>
        <button type="submit" class="button is-primary is-outlined">Guardar</button>
    </p>
    <br>
    <article class="message is-info">
        <div class="message-body">
            "Para proceder con la solicitud de servicio, es necesario que estés <strong>registrado</strong> en nuestro sistema. Si aún no tienes una cuenta, te invitamos a crearla para acceder a todas nuestras funcionalidades. El <strong>registro</strong> asegura la protección de tus datos y una experiencia personalizada. <em>Al finalizar el registro, podrás disfrutar de nuestros servicios y beneficios.</em> Tu cuenta te permitirá gestionar tus datos y acceder a actualizaciones y herramientas de manera segura. <a href="<?php echo APP_URL; ?>customerNew/" '>Haz clic aquí si no te has registrado.</a>"
        </div>
    </article>
</form>

</div>