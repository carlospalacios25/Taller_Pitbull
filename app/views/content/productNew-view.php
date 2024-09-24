<div class="container is-fluid mb-6">
	<h1 class="title">Producto</h1>
</div>

<div class="container pb-6 pt-6">
<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/productoAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">

    <input type="hidden" name="Modulo_Producto" value="registrar">

    <div class="columns">
        <div class="column">
            <div class="control">
                <label>Nombre Producto</label>
                <input class="input" type="text" name="nom_producto" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,45}" maxlength="45" required>
            </div>
        </div>
        <div class="column">
            <div class="control">
                <label>Codigo Producto</label>
                <input class="input" type="text" name="codigo" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,40}" maxlength="45" required>
            </div>
        </div>
    </div>
    <div class="columns">
        <div class="column">
            <div class="control">
                <label>Descripcion Producto</label>
                <input class="input" type="text" name="descripcion" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,40}" maxlength="45" required>
            </div>
        </div>
        <div class="column">
            <div class="control">
                <label>Precio Producto</label>
                <input class="input" type="number" name="precio_unitario" pattern="[0-9]{0,40}" maxlength="10" required>
            </div>
        </div>
    </div>
    <div class="columns">
        <div class="column">
            <div class="control">
                <label>Existencias</label>
                <input class="input" type="number" name="existencias" pattern="[0-9]{0,40}" maxlength="10" required>
            </div>
        </div>
        <div class="column">
            <div class="control">
            </div>
        </div>
    </div>
    <p class="has-text-centered">
        <button type="reset" class="button is-link is-light is-rounded">Limpiar</button>
        <button type="submit" class="button is-info is-rounded">Guardar</button>
    </p>
</form>

    <div class="container is-fluid mb-6">
        <h6 class="title">Listado de Productos</h6>
    </div>
    <div class="container pb-6 pt-6">
        <?php
            use app\controllers\productController; 
            $insUsuario = new productController();

            echo $insUsuario->listarProductoControlador($url[1],5,$url[0],"");
        ?>
</div>
</div>