<div class="container is-fluid mb-6">
    <?php 
    $id = $insLogin->limpiarCadena($url[1]);

    if ($id != $_SESSION['id']) { 
    ?>
        <h1 class="title">Asignar Servicio</h1>
    <?php }else{ ?>
        <h1 class="title">Servicio Ya Asignado</h1>
    <?php } ?>
    
</div>

<div class="container pb-6 pt-6">
    <?php
        use app\controllers\serviceController;
        include "./app/views/inc/btn_back.php";

        $datos = $insLogin->seleccionarDatos("Unico", "servicios", "id_servicios", $id);

        if ($datos && $datos->rowCount() == 1) {
            $datos = $datos->fetch();
    ?>
        <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/serviceAjax.php" method="POST" autocomplete="off">
            <input type="hidden" name="Modulo_Servicio" value="actualizarEmple">
            <input type="hidden" name="id_servicios" value="<?php echo isset($datos['id_servicios']) ? $datos['id_servicios'] : ''; ?>">

        <div>
            <p class="heading is-size-6">Id de servicio:
            <span class="tag is-success is-medium">
                <?php echo isset($datos['id_servicios']) ? $datos['id_servicios'] : 'No disponible'; ?>
            </span>
            </p>
        </div>
            <br>
            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label>Especificación Del Mantenimiento</label>
                        <input class="input" type="text" name="observaciones" maxlength="1000" 
                                value="<?php echo isset($datos['observaciones']) ? $datos['observaciones'] : ''; ?>" required>
                    </div>
                </div>
                <div class="column">
                    <div class="select is-normal">
                        <label>Empleado A Cargo</label>
                        <select name="documento_emp" id="documento_emp">
                            <option selected disabled value="">Asignar Empleado</option>
                            <?php
                                $controlador = new serviceController();
                                echo $controlador->obtenerOpcionesEmpleado();
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <p class="has-text-centered">
                <button type="submit" class="button is-success is-rounded">Actualizar</button>
            </p>
        </form>
<?php
    } else {
        // Mensaje de error si no hay datos
        include "./app/views/inc/error_alert.php";
        echo "<p class='has-text-centered'>No hay servicios disponibles para asignar.</p>";
    }
?>    
</div>
s

