<?php
	/*Servicio*/
	namespace app\controllers;
	use app\models\mainModel;
	use Exception;

	class serviceController extends mainModel{


		/*----------  Controlador registrar  ----------*/
		public function registrarServicioControlador(){
    		// Almacenando datos
			$cedulaCli = $this->limpiarCadena($_POST['cedula_cliente']);
			$observacionSer = $this->limpiarCadena($_POST['observaciones']);			
			
			
			// Verificando campos obligatorios
			if ($cedulaCli == "" || $observacionSer == "") {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "No has llenado todos los campos que son obligatorios",
					"icono" => "error"
				];
				return json_encode($alerta);
			}

			// Verificando formato de datos
			if ($this->verificarDatos("[0-9]{3,40}", $cedulaCli)) {
				
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "El Servicio no coincide con el formato solicitado",
					"icono" => "error"
				];
				return json_encode($alerta);
			}

			// Verificando usuario
			$check_documentoCli = $this->ejecutarConsulta("SELECT cedula FROM cliente WHERE cedula='$cedulaCli'");
			if ($check_documentoCli->rowCount() < 1) {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Cliente No Registrado",
					"texto" => "El cliente No Existe",
					"icono" => "error"
				];
				return json_encode($alerta);
			}

			// Datos a registrar
			$servicio_reg = [
				[
					"campo_nombre" => "cedula_cliente",
					"campo_marcador" => ":Cedula",
					"campo_valor" => $cedulaCli
				],
				[
					"campo_nombre" => "observaciones",
					"campo_marcador" => ":observaciones",
					"campo_valor" => $observacionSer
				],
			];

			try {
				$registrar_servicio = $this->guardarDatos("servicios", $servicio_reg);
				
				if ($registrar_servicio->rowCount() == 1) {
					$consulta_id = $this->ejecutarConsulta("SELECT id_servicios FROM servicios ORDER BY id_servicios DESC LIMIT 1");
        			$idServicio = $consulta_id->fetchColumn();

					$alerta = [
						"tipo" => "limpiar",
						"titulo" => "Servicio registrado",
						"texto" => "Tu número de servicio es: " . $idServicio,
						"icono" => "success"
					];
				} else {
					$alerta = [
						"tipo" => "simple",
						"titulo" => "Ocurrió un error inesperado",
						"texto" => "No se pudo crear, por favor intente nuevamente",
						"icono" => "error"
					];
				}
			} catch (Exception $e) {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "Error de servidor Conctata a un encargado ",
					"icono" => "error"
				];
			}

			return json_encode($alerta);
		}
		/*----------  Controlador listar   ----------*/
		public function listadoServiciosPorAsignarControlador($pagina, $registros, $url, $busqueda) {

			$pagina = $this->limpiarCadena($pagina);
			$registros = $this->limpiarCadena($registros);
		
			$url = $this->limpiarCadena($url);
			$url = APP_URL . $url . "/";
		
			$busqueda = $this->limpiarCadena($busqueda);
			$tabla = "";
		
			$pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1;
			$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
		
			if (isset($busqueda) && $busqueda != "") {
				$consulta_datos = "SELECT * FROM servicios WHERE (cedula_cliente LIKE '%$busqueda%' OR documento_emp LIKE '%$busqueda%') ORDER BY id_servicios  ASC LIMIT $inicio, $registros";
				$consulta_total = "SELECT COUNT(cedula) FROM servicios WHERE (cedula_cliente LIKE '%$busqueda%' OR documento_emp LIKE '%$busqueda%')";
			} else {
				$consulta_datos="SELECT servicios.id_servicios, servicios.observaciones, cliente.nom_cliente, cliente.ape_cliente 
							FROM servicios
							INNER JOIN cliente ON servicios.cedula_cliente = cliente.cedula 
							WHERE servicios.documento_emp IS NULL 
							LIMIT $inicio, $registros;
							";
				$consulta_total = "SELECT COUNT(id_servicios) FROM servicios  WHERE documento_emp IS NULL";

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
							<th class="has-text-centered">Servicio</th>
							<th class="has-text-centered">Mantenimiento</th>
							<th class="has-text-centered">Cliente</th>
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
							<td>' . $rows['id_servicios'] . '</td>
							<td>' . $rows['observaciones'] .'</td>
							<td>' . $rows['nom_cliente'] .' '. $rows['ape_cliente'].' </td>
							<td>
								<a href="' . APP_URL . 'serviceUpdateEmpl/' . $rows['id_servicios'] . '/" class="button is-success is-rounded is-small">Asignar</a>
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
				$tabla .= '<p class="has-text-right">Servicios Pendiente Por Asignar <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total . '</strong></p>';
		
				$tabla .= $this->paginadorTablas($pagina, $numeroPaginas, $url, 10);
			}
		
			return $tabla;
		}

		/*----------  Controlador actualizar   ----------*/
		public function actualizarServicioEmpleControlador(){

			$idservicio = $this->limpiarCadena($_POST['id_servicios']);
			
			# Verificando usuario #
			$datos = $this->ejecutarConsulta("SELECT * FROM servicios WHERE id_servicios = '$idservicio' AND documento_emp IS NULL LIMIT 2;");

			
			if ($datos->rowCount() <= 0) {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "No hemos encontrado el Servicio en el sistema y/o ya asignado",
					"icono" => "error"
				];
				return json_encode($alerta);
			} else {
				$datos = $datos->fetch();
			}
		
			# Almacenando datos #
			$observacionServ = $this->limpiarCadena($_POST['observaciones']);
			$documentoEmple = isset($_POST['documento_emp']) ? $this->limpiarCadena($_POST['documento_emp']) : NULL;
		
			# Verificando campos obligatorios #
			if ($observacionServ == "") {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "No has llenado todos los campos que son obligatorios",
					"icono" => "error"
				];
				return json_encode($alerta);
			}
	
		
			$servicios_datos_up = [
				[
					"campo_nombre" => "observaciones",
					"campo_marcador" => ":Observaciones",
					"campo_valor" => $observacionServ
				],
				[
					"campo_nombre" => "documento_emp",
					"campo_marcador" => ":Empleado",
					"campo_valor" => $documentoEmple
				],
			];
		
			$condicion = [
				"condicion_campo" => "id_servicios",
				"condicion_marcador" => ":IdServicios",
				"condicion_valor" => $idservicio
			];
		
			if ($this->actualizarDatos("servicios", $servicios_datos_up, $condicion)) {
				$alerta = [
					"tipo" => "recargar",
					"titulo" => "Tipo proveedor actualizado",
					"texto" => "Servicio asignado a " . $documentoEmple,
					"icono" => "success"
				];
			} else {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "No hemos podido actualizar los datos del servicio " . $documentoEmple . ", por favor intente nuevamente",
					"icono" => "error"
				];
			}
		
			return json_encode($alerta);
		}		

		public function obtenerOpcionesEmpleado($busqueda = "") {
			$busqueda = $this->limpiarCadena($busqueda);
			
			if ($busqueda != "") {
				$consulta_datos = "SELECT * FROM cargos WHERE (id_cargos LIKE :busqueda OR tipo_cargo LIKE :busqueda) ORDER BY id_cargos ASC";
			} else {
				$consulta_datos = "SELECT * FROM empleado ORDER BY documento_emp  ASC";
			}
			
			$stmt = $this->ejecutarConsulta($consulta_datos);
		
			if ($busqueda != "") {
				$stmt->bindValue(':busqueda', '%' . $busqueda . '%');
			}
			
			$stmt->execute();
		
			$datos = $stmt->fetchAll();
		
			$opciones = '';
			foreach ($datos as $row) {
				$opciones .= '<option value="' . htmlspecialchars($row['documento_emp']) . '">' . htmlspecialchars($row['nom_empleado']) . ' ' . htmlspecialchars($row['ape_empleado']) . '</option>';
			}
		
			// Devolver las opciones generadas
			return $opciones;
		}
	}