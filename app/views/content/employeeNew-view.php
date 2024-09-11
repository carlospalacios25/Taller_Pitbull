<div class="container is-fluid mb-6">
	<h1 class="title">Empleado</h1>
	<h2 class="subtitle">Nuevo Proveedor</h2>
</div>

<div class="container pb-6 pt-6">
<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/empleadoAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">

    <input type="hidden" name="Modulo_Empleado" value="registrar">

    <div class="columns">
        <div class="column">
            <div class="control">
                <label>Documento</label>
                <input class="input" type="number" name="documento_emp" pattern="[0-9]{3,40}" maxlength="16" required>
            </div>
        </div>
        <div class="column">
            <div class="control">
                <label>Nombre Empleado</label>
                <input class="input" type="text" name="nom_empleado" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="70" required>
            </div>
        </div>
    </div>
    <div class="columns">
        <div class="column">
            <div class="control">
                <label>Apellido Empleado</label>
                <input class="input" type="text" name="ape_empleado" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="75" required>
            </div>
        </div>
        <div class="column">
            <div class="control">
                <label>Direccion Empleado</label>
                <input class="input" type="text" name="direccion" maxlength="100">
            </div>
        </div>
    </div>
    <div class="columns">
        <div class="column">
            <div class="control">
                <label>Telefono Empleado</label>
                <input class="input" type="number" name="telefono" pattern="[0-9]{3,40}" maxlength="15" required>
            </div>
        </div>
        <div class="column">
            <div class="select is-normal">
                <label>Cargo</label>
                <select name="id_cargos" id="id_cargos">
					<?php
						use app\controllers\employeeController; 
						$controlador = new employeeController();
						echo $controlador->obtenerOpcionesCargo();
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
        <h6 class="title">Listado de Empleados</h6>
    </div>
    <div class="container pb-6 pt-6">
        <?php
            $insUsuario = new employeeController();

            echo $insUsuario->listarEmpleadoControlador($url[1],5,$url[0],"");
        ?>
</div>
</div>