<div class="container is-fluid mb-6">
    <?php 

    $id=$insLogin->limpiarCadena($url[1]);

    if($id != $_SESSION['id']){ 
    ?>
        <h1 class="title">Actualizar Producto</h1>
    <?php } ?>
</div>

<div class="container pb-6 pt-6">
    <?php
        use app\controllers\productController;
        include "./app/views/inc/btn_back.php";

        $datos=$insLogin->seleccionarDatos("Unico","producto","id_producto",$id);

        if($datos->rowCount()==1){
            $datos=$datos->fetch();
    ?>
    <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/productoAjax.php" method="POST" autocomplete="off" >

        <input type="hidden" name="Modulo_Producto" value="actualizar">
        <input type="hidden" name="id_producto" value="<?php echo $datos['id_producto']; ?>">

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Nombre Producto</label>
                    <input class="input" type="text" name="nom_producto" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,45}" maxlength="45" value="<?php echo $datos['nom_producto']; ?>" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Codigo Producto</label>
                    <input class="input" type="text" name="codigo" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,40}" maxlength="45" value="<?php echo $datos['codigo']; ?>" required>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Descripcion</label>
                    <input class="input" type="text" name="descripcion" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,40}" maxlength="45" value="<?php echo $datos['descripcion']; ?>" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Precio Producto</label>
                    <input class="input" type="text" name="precio_unitario"  pattern="[0-9]{0,40}" maxlength="10" value="<?php echo $datos['precio_unitario']; ?>">
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Exitencias</label>
                    <input class="input" type="number" name="existencias" pattern="[0-9]{3,40}" maxlength="15" value="<?php echo $datos['existencias']; ?>" required>
                </div>
            </div>
        <div class="column">

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
