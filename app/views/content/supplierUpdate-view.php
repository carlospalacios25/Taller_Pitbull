<div class="container is-fluid mb-6">
    <?php 
        $id=$insLogin->limpiarCadena($url[1]);
        if($id==$_SESSION['id']){ 
    ?>
    <h1 class="title">Mi cuenta</h1>
    <h2 class="subtitle">Actualizar cuenta</h2>
    <?php }else{ ?>
    <h1 class="title">Proveedor</h1>
    <h2 class="subtitle">Actualizar Proveedor</h2>
    <?php } ?>
</div>

<div class="container pb-6 pt-6">
    <?php
        use app\controllers\supplierController;
        include "./app/views/inc/btn_back.php";

        $datos=$insLogin->seleccionarDatos("Unico","proveedor","documento_NIT",$id);

        if($datos->rowCount()==1){
            $datos=$datos->fetch();
    ?>
    <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/proveedorAjax.php" method="POST" autocomplete="off" >

        <input type="hidden" name="Modulo_Proveedor" value="actualizar">
        <input type="hidden" name="documento_NIT" value="<?php echo $datos['documento_NIT']; ?>">

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>NIT(Documento)</label>
                    <input class="input" type="number" name="documento_NIT" pattern="[0-9]{3,40}" maxlength="16" value="<?php echo $datos['documento_NIT']; ?>" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Nombre Proveedor</label>
                    <input class="input" type="text" name="nom_proveedor" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="70" value="<?php echo $datos['nom_proveedor']; ?>" required>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Apellido (Razon Social)</label>
                    <input class="input" type="text" name="apellido_sociedad" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="75" value="<?php echo $datos['apellido_sociedad']; ?>" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Direccion</label>
                    <input class="input" type="text" name="direccion" maxlength="100" value="<?php echo $datos['direccion']; ?>">
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Telefono</label>
                    <input class="input" type="number" name="telefono" pattern="[0-9]{3,40}" maxlength="15" value="<?php echo $datos['telefono']; ?>" required>
                </div>
            </div>
        <div class="column">
            <div class="select is-normal">
            <label>Tipo Proveedor</label>
            <select name="id_tipo_proveedor" id="id_tipo_proveedor">
                <?php
                // Obtener el id_tipo_proveedor del proveedor actual
                $id_tipo_proveedor_actual = $datos['id_tipo_proveedor'];  // Este valor lo traes del proveedor que se está actualizando
                
                // Controlador para obtener las opciones
                $controlador = new supplierController();
                echo $controlador->obtenerOpcionesTipoProveedorActual($id_tipo_proveedor_actual);  // Pasa el id actual para seleccionar la opción correcta
                ?> 
            </select>
            </div>
        </div>
        </div>
        <p class="has-text-centered">
            Para poder actualizar los datos de tipo proveedor por favor ingrese su USUARIO y CLAVE con la que ha iniciado sesión
        </p>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Usuario</label>
                    <input class="input" type="text" name="administrador_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required >
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Clave</label>
                    <input class="input" type="password" name="administrador_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required >
                </div>
            </div>
        </div>
        <p class="has-text-centered">
            <button type="submit" class="button is-success is-rounded">Actualizar</button>
        </p>
    </form>
    <?php
        }else{
            include "./app/views/inc/error_alert.php";
        }
    ?>  
</div>
