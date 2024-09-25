<div class="container is-fluid mb-6">
	<h1 class="title">Registrarme</h1>
</div>

<div class="container pb-6 pt-6">
<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/clienteAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">

    <input type="hidden" name="Modulo_Cliente" value="registrar">

    <div class="columns">
        <div class="column">
            <div class="control">
                <label>Documento</label>
                <input class="input" type="number" name="cedula" pattern="[0-9]{3,40}" maxlength="16" required>
            </div>
        </div>
        <div class="column">
            <div class="control">
                <label>Nombre</label>
                <input class="input" type="text" name="nom_cliente" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="70" required>
            </div>
        </div>
    </div>
    <div class="columns">
        <div class="column">
            <div class="control">
                <label>Apellido</label>
                <input class="input" type="text" name="ape_cliente" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="75" required>
            </div>
        </div>
        <div class="column">
            <div class="control">
                <label>Direccion</label>
                <input class="input" type="text" name="direccion" maxlength="100">
            </div>
        </div>
    </div>
    <div class="columns">
        <div class="column">
            <div class="control">
                <label>Telefono</label>
                <input class="input" type="number" name="telefono" pattern="[0-9]{3,40}" maxlength="15" required>
            </div>
        </div>
        <div class="column">
            
        </div>
    </div>
    <p class="has-text-centered">
        <button type="reset" class="button is-danger is-outlined">Limpiar</button>
        <button type="submit" class="button is-primary is-outlined">Guardar</button>
    </p>
</form>

</div>