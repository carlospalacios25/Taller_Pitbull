<section class="section">
        <div class="container">
            <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/compraAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                <input type="hidden" name="Modulo_Compra" value="registrar">
                
                <div class="columns">
                    <div class="column">
                        <div class="box">
                            <p class="title is-5">Detalle del Proveedor</p>
                            <div class="select is-fullwidth">
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
                    </div>
                    <div class="column">
                        <div class="box">
                            <p class="title is-5">ID Compra</p>
                            <input class="input" type="text" name="id_compra" maxlength="10" required>
                        </div>
                    </div>
                    <div class="column">
                        <div class="box">
                            <p class="title is-5">Fecha de Compra</p>
                            <input class="input" type="date" name="fecha_compra" required>
                        </div>
                    </div>
                </div>

                <div class="box">
                    <table class="table is-fullwidth">
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th>Cantidad</th>
                                <th>Precio unitario</th>
                                <th>% IVA</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="productos-tbody">
                            <tr class="producto-item">
                                <td>
                                    <div class="select is-fullwidth">
                                        <select name="id_producto[]" class="producto-select">
                                            <option selected disabled value="">Seleccione Producto</option>
                                            <?php
                                                echo $controlador->obtenerOpcionesProducto();
                                            ?>
                                        </select>
                                    </div>
                                </td>
                                <td><input class="input cantidad" type="number" name="cantidad[]" maxlength="10" required></td>
                                <td><input class="input precio_unitario" type="number" step="0.01" name="precio_unitario[]" maxlength="20" required></td>
                                <td><input class="input impuesto_iva" type="number" step="0.01" name="impuesto_iva[]" maxlength="20" required></td>
                                <td><input class="input precio_total" type="text" name="precio_total[]" readonly></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="has-text-right">NETO $</th>
                                <td id="neto">0.00</td>
                            </tr>
                            <tr>
                                <th colspan="3" class="has-text-right">IVA (%) $</th>
                                <td id="iva">0.00</td>
                            </tr>
                            <tr>
                                <th colspan="3" class="has-text-right">TOTAL $</th>
                                <td id="total">0.00</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="field is-grouped is-grouped-centered">
                    <p class="control">
                        <button type="button" id="agregar-producto" class="button is-success is-rounded">Agregar Producto</button>
                    </p>
                    <p class="control">
                        <button type="reset" class="button is-link is-light is-rounded">Limpiar</button>
                    </p>
                    <p class="control">
                        <button type="submit" class="button is-info is-rounded">Guardar</button>
                    </p>
                </div>
            </form>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tbody = document.getElementById('productos-tbody');
            const agregarProductoBtn = document.getElementById('agregar-producto');
            const limpiarBtn = document.querySelector('button[type="reset"]'); // Seleccionamos el botón de limpiar

            agregarProductoBtn.addEventListener('click', agregarProducto);
            tbody.addEventListener('input', actualizarTotales);

            // Delegar el evento change para los selectores de productos
            tbody.addEventListener('change', function(event) {
                if (event.target.classList.contains('producto-select')) {
                    const productoId = event.target.value;

                    // Hacer la llamada AJAX para obtener el precio del producto
                    if (productoId) {
                        fetch(`<?php echo APP_URL; ?>app/ajax/getProductPrice.php?id_producto=${productoId}`)
                            .then(response => response.text())  // Cambiar a 'text' para ver la respuesta sin procesar
                            .then(data => {
                                try {
                                    const jsonData = JSON.parse(data);  // Intentar convertirlo a JSON
                                    if (jsonData.precio_unitario) {
                                        const precioUnitarioInput = event.target.closest('tr').querySelector('.precio_unitario');
                                        precioUnitarioInput.value = jsonData.precio_unitario;
                                    }
                                } catch (e) {
                                    console.error('No se pudo procesar JSON', e);
                                }
                            })
                            .catch(error => console.error('Error al obtener el precio:', error));
                    }
                }
            });

            formulario.addEventListener('submit', function(event) {
                event.preventDefault();

                const filas = tbody.querySelectorAll('.producto-item');
                for (let i = 1; i < filas.length; i++) {
                    filas[i].remove(); 
                }

                formulario.reset();
            });

            function agregarProducto() {
                const nuevaFila = tbody.rows[0].cloneNode(true);
                nuevaFila.querySelectorAll('input').forEach(input => input.value = '');
                nuevaFila.querySelector('select').selectedIndex = 0;
                tbody.appendChild(nuevaFila);
            }

            limpiarBtn.addEventListener('click', function() {
                const form = document.querySelector('form');
                form.reset();

                const filas = tbody.querySelectorAll('.producto-item');
                for (let i = 1; i < filas.length; i++) { 
                    filas[i].remove();
                }
                

                document.getElementById('neto').textContent = '0.00';
                document.getElementById('iva').textContent = '0.00';
                document.getElementById('total').textContent = '0.00';
            });

            function actualizarTotales() {
                let neto = 0;
                let totalIVA = 0;

                document.querySelectorAll('.producto-item').forEach(fila => {
                    const cantidad = parseFloat(fila.querySelector('.cantidad').value) || 0;
                    const precioUnitario = parseFloat(fila.querySelector('.precio_unitario').value) || 0;
                    const porcentajeIVA = parseFloat(fila.querySelector('.impuesto_iva').value) || 0;

                    const subtotal = cantidad * precioUnitario;
                    const ivaCalculado = subtotal * (porcentajeIVA / 100);
                    const totalConIVA = subtotal + ivaCalculado;

                    fila.querySelector('.precio_total').value = totalConIVA.toFixed(2);

                    neto += subtotal;
                    totalIVA += ivaCalculado;
                });

                const totalGeneral = neto + totalIVA;

                document.getElementById('neto').textContent = neto.toFixed(2);
                document.getElementById('iva').textContent = totalIVA.toFixed(2);
                document.getElementById('total').textContent = totalGeneral.toFixed(2);
            }
        });
       
    </script>