<?php
	/*Compra*/
	namespace app\controllers;
	use app\models\mainModel;
	use Exception;

	class buysController extends mainModel{

		/*----------  Controlador registrar  ----------*/
		public function registrarCompraControlador() {
			// Almacenando datos generales
			$id_compra = $this->limpiarCadena($_POST['id_compra']);
			$doc_proveedor = isset($_POST['doc_proveedor']) ? $this->limpiarCadena($_POST['doc_proveedor']) : null;
			$fecha_compra = isset($_POST['fecha_compra']) ? $this->limpiarCadena($_POST['fecha_compra']) : null;
		
			// Almacenando datos de productos (arrays)
			$productos = isset($_POST['id_producto']) ? $_POST['id_producto'] : [];
			$precios = isset($_POST['precio_total']) ? $_POST['precio_total'] : [];
			$preciounitario = isset($_POST['precio_unitario']) ? $_POST['precio_unitario'] : [];
			$impuesto = isset($_POST['impuesto_iva']) ? $_POST['impuesto_iva'] : [];
			$cantidades = isset($_POST['cantidad']) ? $_POST['cantidad'] : [];
			
			
			// Verificando campos obligatorios
			if ($id_compra == "" || $doc_proveedor == "" || $fecha_compra == "") {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "No has llenado todos los campos que son obligatorios",
					"icono" => "error"
				];
				return json_encode($alerta);
			}
		
			// Verificando si hay productos
			if (empty($productos)) {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "No has agregado ningún producto",
					"icono" => "error"
				];
				return json_encode($alerta);
			}
		
			// Insertando datos de compra
			try {
				for ($i = 0; $i < count($productos); $i++) {
					$producto = $this->limpiarCadena($productos[$i]);
					$precio = $this->limpiarCadena($precios[$i]);
					$cantidad = $this->limpiarCadena($cantidades[$i]);
		
					// Datos a registrar para cada producto
					$compra_reg = [
						[
							"campo_nombre" => "id_compra",
							"campo_marcador" => ":IdCompra",
							"campo_valor" => $id_compra
						],
						[
							"campo_nombre" => "doc_proveedor",
							"campo_marcador" => ":DocProveedor",
							"campo_valor" => $doc_proveedor
						],
						[
							"campo_nombre" => "fecha_compra", // Nueva línea para fecha de compra
							"campo_marcador" => ":FechaCompra",
							"campo_valor" => $fecha_compra
						],
						[
							"campo_nombre" => "id_producto",
							"campo_marcador" => ":IdProducto",
							"campo_valor" => $producto
						],
						[
							"campo_nombre" => "precio_unitario",
							"campo_marcador" => ":PrecioUnitario",
							"campo_valor" => $preciounitario
						],
						[
							"campo_nombre" => "impuesto_iva",
							"campo_marcador" => ":Impuesto",
							"campo_valor" => $impuesto
						],
						[
							"campo_nombre" => "precio_total",
							"campo_marcador" => ":PrecioTotal",
							"campo_valor" => $precio
						],
						[
							"campo_nombre" => "cantidad",
							"campo_marcador" => ":Cantidad",
							"campo_valor" => $cantidad
						]
					];
		
					// Guardar datos
					$registrar_compra = $this->guardarDatos("compra", $compra_reg);
					if ($registrar_compra->rowCount() != 1) {
						throw new Exception("Error al registrar el producto: $producto");
					}
				}
		
				// Si todo va bien
				$alerta = [
					"tipo" => "limpiar",
					"titulo" => "Compra registrada",
					"texto" => "La compra ".$id_compra ." fue registrada con éxito",
					"icono" => "success"
				];
			} catch (Exception $e) {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "Error en la base de datos: " . $e->getMessage(),
					"icono" => "error"
				];
			}
		
			return json_encode($alerta);
		}
	
			
		/*----------  Controlador listar   ----------*/
		public function listarProveedorControlador($pagina, $registros, $url, $busqueda) {

			$pagina = $this->limpiarCadena($pagina);
			$registros = $this->limpiarCadena($registros);
		
			$url = $this->limpiarCadena($url);
			$url = APP_URL . $url . "/";
		
			$busqueda = $this->limpiarCadena($busqueda);
			$tabla = "";
		
			$pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1;
			$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
		
			if (isset($busqueda) && $busqueda != "") {
				$consulta_datos = "SELECT * FROM proveedor WHERE (documento_NIT LIKE '%$busqueda%' OR 	nom_proveedor LIKE '%$busqueda%') ORDER BY documento_NIT ASC LIMIT $inicio, $registros";
				$consulta_total = "SELECT COUNT(id_tipo_proveedor) FROM proveedor WHERE (documento_NIT LIKE '%$busqueda%' OR id_tipo_proveedor LIKE '%$busqueda%')";
			} else {
				$consulta_datos = "SELECT * FROM proveedor ORDER BY documento_NIT ASC LIMIT $inicio, $registros";
				$consulta_total = "SELECT COUNT(documento_NIT) FROM proveedor";
			}
		
			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();
		
			$total = $this->ejecutarConsulta($consulta_total);
			$total = (int)$total->fetchColumn();
		
			$numeroPaginas = ceil($total / $registros);
		
			$tabla .= '
				<div class="table-container">
				<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
					<thead>
						<tr>
							<th class="has-text-centered">#</th>
							<th class="has-text-centered">Documento</th>
							<th class="has-text-centered">Nombre Completo</th>
							<th class="has-text-centered">Direccion</th>
							<th class="has-text-centered">Telefono</th>
							<th class="has-text-centered" colspan="3">Opciones</th>
						</tr>
					</thead>
					<tbody>
			';
		
			if ($total >= 1 && $pagina <= $numeroPaginas) {
				$contador = $inicio + 1;
				$pag_inicio = $inicio + 1;
				foreach ($datos as $rows) {
					$tabla .= '
						<tr class="has-text-centered">
							<td>' . $contador . '</td>
							<td>' . $rows['documento_NIT'] . '</td>
							<td>' . $rows['nom_proveedor'] . ''.$rows['apellido_sociedad'].'</td>
							<td>' . $rows['direccion'] . '</td>
							<td>' . $rows['telefono'] . '</td>
							<td>
								<a href="' . APP_URL . 'supplierUpdate/' . $rows['documento_NIT'] . '/" class="button is-success is-rounded is-small">Actualizar</a>
							</td>
						</tr>
					';
					$contador++;
				}
				$pag_final = $contador - 1;
			} else {
				if ($total >= 1) {
					$tabla .= '
						<tr class="has-text-centered">
							<td colspan="7">
								<a href="' . $url . '1/" class="button is-link is-rounded is-small mt-4 mb-4">
									Haga clic acá para recargar el listado
								</a>
							</td>
						</tr>
					';
				} else {
					$tabla .= '
						<tr class="has-text-centered">
							<td colspan="7">
								No hay registros en el sistema
							</td>
						</tr>
					';
				}
			}
		
			$tabla .= '</tbody></table></div>';
		
			### Paginacion ###
			if ($total >= 1 && $pagina <= $numeroPaginas) {
				$tabla .= '<p class="has-text-right">Mostrando usuarios <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total . '</strong></p>';
		
				$tabla .= $this->paginadorTablas($pagina, $numeroPaginas, $url, 10);
			}
		
			return $tabla;
		}

		public function obtenerOpcionesProducto($busqueda = "") {
			$busqueda = $this->limpiarCadena($busqueda);
			
			$consulta_datos = "SELECT * FROM producto ORDER BY id_producto  ASC";
			
			$stmt = $this->ejecutarConsulta($consulta_datos);
		
			if ($busqueda != "") {
				$stmt->bindValue(':busqueda', '%' . $busqueda . '%');
			}
			
			$stmt->execute();
		
			$datos = $stmt->fetchAll();
		
			$opciones = '';
			foreach ($datos as $row) {
				$opciones .= '<option value="' . htmlspecialchars($row['id_producto']) . '">' . htmlspecialchars($row['nom_producto']) . '</option>';
			}
		
			// Devolver las opciones generadas
			return $opciones;
		}

		public function obtenerProveedor($busqueda = "") {
			$busqueda = $this->limpiarCadena($busqueda);
			
			$consulta_datos = "SELECT * FROM proveedor ORDER BY documento_NIT  ASC";
			
			$stmt = $this->ejecutarConsulta($consulta_datos);
		
			if ($busqueda != "") {
				$stmt->bindValue(':busqueda', '%' . $busqueda . '%');
			}
			
			$stmt->execute();
		
			$datos = $stmt->fetchAll();
		
			$opciones = '';
			foreach ($datos as $row) {
				$opciones .= '<option value="' . htmlspecialchars($row['documento_NIT']) . '">' . htmlspecialchars($row['nom_proveedor']) . ' ' . htmlspecialchars($row['apellido_sociedad']). '</option>';
			}
		
			// Devolver las opciones generadas
			return $opciones;
		}
		
	}