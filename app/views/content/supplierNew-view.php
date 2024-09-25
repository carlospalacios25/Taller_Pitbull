<div class="container is-fluid mb-6">
	<h1 class="title">Proveedor</h1>
	<h2 class="subtitle">Nuevo Proveedor</h2>
</div>

<div class="container pb-6 pt-6">
<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/proveedorAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">

    <input type="hidden" name="Modulo_Proveedor" value="registrar">

    <div class="columns">
        <div class="column">
            <div class="control">
                <label>NIT(Documento)</label>
                <input class="input" type="number" name="documento_NIT" pattern="[0-9]{3,40}" maxlength="16" required>
            </div>
        </div>
        <div class="column">
            <div class="control">
                <label>Nombre Proveedor</label>
                <input class="input" type="text" name="nom_proveedor" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="70" required>
            </div>
        </div>
    </div>
    <div class="columns">
        <div class="column">
            <div class="control">
                <label>Apellido (Razon Social)</label>
                <input class="input" type="text" name="apellido_sociedad" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="75" required>
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
            <div class="select is-normal">
                <label>Tipo Proveedor</label>
                <select name="id_tipo_proveedor" id="id_tipo_proveedor">
                <option selected disabled value="">Selecione Tipo Proveedor</option>
					<?php
						use app\controllers\supplierController; 
						$controlador = new supplierController();
						echo $controlador->obtenerOpcionesTipoProveedor();
					?>
                </select>
            </div>
        </div>
    </div>
    <p class="has-text-centered">
        <button type="reset" class="button is-link is-light is-rounded">Limpiar</button>
        <button type="submit" class="button is-info is-rounded">Guardar</button>
    </p>
</form>
    <div class="container is-fluid mb-6">
        <h6 class="title">Listado de Proveedores</h6>
    </div>
    <div class="container pb-6 pt-6">
        <!--	<div class="container pb-6 pt-6">
            <a href="<?php echo APP_URL; ?>app/views/fpdf/PruebaVP.php" target="_blank" class="button is-primary is-outlined">Generar Reporte General</a>
        </div>-->

        <?php
            $insUsuario = new supplierController();

            echo $insUsuario->listarProveedorControlador($url[1],5,$url[0],"");
        ?>
</div>
</div>