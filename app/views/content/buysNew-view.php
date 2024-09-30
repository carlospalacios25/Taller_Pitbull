<div class="container is-fluid mb-6">
    <h1 class="title">Compra</h1>
    <h2 class="subtitle">Nueva Compra</h2>
</div>

<div class="container pb-6 pt-6">
<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/compraAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">

    <input type="hidden" name="Modulo_Compra" value="registrar">

    <div class="columns">
        <div class="column">
            <div class="control">
                <label>ID Compra</label>
                <input class="input" type="text" name="id_compra" maxlength="10" required>
            </div>
        </div>
        <div class="column">
            <div class="select is-normal">
                <label>Selecion Producto</label>
                <select name="doc_proveedor" id="doc_proveedor">
                <option selected disabled value="">Selecione Proveedor</option>
                    <?php
                        use app\controllers\buysController; 
                        $controlador = new buysController();
                        echo $controlador->obtenerProveedor();
                    ?>
                </select>
            </div>
        </div>
        <div class="column">
            <div class="control">
                <label>Fecha de Compra</label>
                <input class="input" type="date" name="fecha_compra" required>
            </div>
        </div>

    </div>

    <!-- Aquí empieza la sección dinámica de productos -->
    <div id="productos-container">
        <div class="columns producto-item">
            <div class="column">
                <div class="select is-normal">
                    <label>Selecion Producto</label>
                    <select name="id_producto[]" id="id_producto">
                    <option selected disabled value="">Selecione Producto</option>
                        <?php
                            $controlador = new buysController();
                            echo $controlador->obtenerOpcionesProducto();
                        ?>
                    </select>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Precio Total</label>
                    <input class="input" type="text" name="precio_total[]" maxlength="20" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Cantidad</label>
                    <input class="input" type="number" name="cantidad[]" maxlength="10" required>
                </div>
            </div>
        </div>
    </div>
    
    <p class="has-text-centered">
        <button type="button" id="agregar-producto" class="button is-success is-rounded">Agregar Producto</button>
        <button type="reset" class="button is-link is-light is-rounded">Limpiar</button>
        <button type="submit" class="button is-info is-rounded">Guardar</button>
    </p>
</form>
</div>

<script src="<?php echo APP_URL; ?>app/views/js/compra.js"></script>
