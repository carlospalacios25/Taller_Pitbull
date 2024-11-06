<?php
	/*Empleado*/
	namespace app\controllers;
	use app\models\mainModel;
	use Exception;

	class employeeController extends mainModel{

		/*----------  Controlador registrar  ----------*/
		public function registrarEmpleadoControlador(){
    		// Almacenando datos
			$documentoEmple = $this->limpiarCadena($_POST['documento_emp']);
			$nombreEmple = $this->limpiarCadena($_POST['nom_empleado']);
			$apellidoEmple = $this->limpiarCadena($_POST['ape_empleado']);
			$direccionEmple = $this->limpiarCadena($_POST['direccion']);
			$telefonoEmple = $this->limpiarCadena($_POST['telefono']);
			$tipoEmple = isset($_POST['id_cargos']) ? $this->limpiarCadena($_POST['id_cargos']) : NULL;

			// Verificando campos obligatorios
			if ($documentoEmple == "" || $nombreEmple == "" || $apellidoEmple == "" || $direccionEmple == "" || $telefonoEmple == "" || $tipoEmple == "") {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "No has llenado todos los campos que son obligatorios",
					"icono" => "error"
				];
				return json_encode($alerta);
			}

			// Verificando formato de datos
			if ($this->verificarDatos("[0-9]{3,40}", $documentoEmple) || 
				$this->verificarDatos("[0-9]{3,40}", $telefonoEmple) || 
				$this->verificarDatos("[0-9]{0,40}", $tipoEmple) || 
				$this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombreEmple) || 
				$this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellidoEmple)) {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "El Empleado no coincide con el formato solicitado",
					"icono" => "error"
				];
				return json_encode($alerta);
			}

			// Verificando usuario
			$check_documentoEmple = $this->ejecutarConsulta("SELECT documento_emp FROM empleado WHERE 	documento_emp='$documentoEmple'");
			if ($check_documentoEmple->rowCount() > 0) {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "El Documento del EMPLEDO ingresado ya se encuentra registrado, por favor elija otro",
					"icono" => "error"
				];
				return json_encode($alerta);
			}

			// Datos a registrar
			$emple_reg = [
				[
					"campo_nombre" => "documento_emp",
					"campo_marcador" => ":Documento",
					"campo_valor" => $documentoEmple
				],
				[
					"campo_nombre" => "nom_empleado",
					"campo_marcador" => ":Nombre",
					"campo_valor" => $nombreEmple
				],
				[
					"campo_nombre" => "ape_empleado",
					"campo_marcador" => ":Apellido",
					"campo_valor" => $apellidoEmple
				],
				[
					"campo_nombre" => "direccion",
					"campo_marcador" => ":Direccion",
					"campo_valor" => $direccionEmple
				],
				[
					"campo_nombre" => "telefono",
					"campo_marcador" => ":Telefono",
					"campo_valor" => $telefonoEmple
				],
				[
					"campo_nombre" => "id_cargos",
					"campo_marcador" => ":Tipo",
					"campo_valor" => $tipoEmple
				],
			];

			try {
				$registrar_empleado = $this->guardarDatos("empleado", $emple_reg);

				if ($registrar_empleado->rowCount() == 1) {
					$alerta = [
						"tipo" => "limpiar",
						"titulo" => "Empleado registrado",
						"texto" => "El Empleado ".$nombreEmple. " ".$apellidoEmple." fue creado con éxito",
						"icono" => "success"
					];
				} else {
					$alerta = [
						"tipo" => "simple",
						"titulo" => "Ocurrió un error inesperado",
						"texto" => "No se pudo registrar el empleado, por favor intente nuevamente",
						"icono" => "error"
					];
				}
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
		public function listarEmpleadoControlador($pagina, $registros, $url, $busqueda) {

			$pagina = $this->limpiarCadena($pagina);
			$registros = $this->limpiarCadena($registros);
		
			$url = $this->limpiarCadena($url);
			$url = APP_URL . $url . "/";
		
			$busqueda = $this->limpiarCadena($busqueda);
			$tabla = "";
		
			$pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1;
			$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
		
			if (isset($busqueda) && $busqueda != "") {
				$consulta_datos = "SELECT * FROM empleado WHERE (documento_emp LIKE '%$busqueda%' OR nom_empleado LIKE '%$busqueda%') ORDER BY documento_emp ASC LIMIT $inicio, $registros";
				$consulta_total = "SELECT COUNT(id_tipo_proveedor) FROM empleado WHERE (documento_emp LIKE '%$busqueda%' OR documento_emp LIKE '%$busqueda%')";
			} else {
				$consulta_datos = "SELECT * FROM empleado ORDER BY documento_emp ASC LIMIT $inicio, $registros";
				$consulta_total = "SELECT COUNT(documento_emp) FROM empleado";
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
							<td>' . $rows['documento_emp'] . '</td>
							<td>' . $rows['nom_empleado']. '  ' .$rows['ape_empleado'].'</td>
							<td>' . $rows['direccion'] . '</td>
							<td>' . $rows['telefono'] . '</td>
							<td>
								<a href="' . APP_URL . 'employeeUpdate/' . $rows['documento_emp'] . '/" class="button is-success is-rounded is-small">Actualizar</a>
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
				$tabla .= '<p class="has-text-right">Mostrando Empleados  <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total . '</strong></p>';
		
				$tabla .= $this->paginadorTablas($pagina, $numeroPaginas, $url, 10);
			}
		
			return $tabla;
		}
		/*----------  Controlador actualizar   ----------*/
		public function actualizarEmpleadoControlador(){

			$documentoEmple=$this->limpiarCadena($_POST['documento_emp']);

			# Verificando usuario #
		    $datos=$this->ejecutarConsulta("SELECT * FROM empleado WHERE documento_emp ='$documentoEmple'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el proveedor en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    $admin_usuario=$this->limpiarCadena($_POST['administrador_usuario']);
		    $admin_clave=$this->limpiarCadena($_POST['administrador_clave']);

		    # Verificando campos obligatorios admin #
		    if($admin_usuario=="" || $admin_clave==""){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No ha llenado todos los campos que son obligatorios, que corresponden a su USUARIO y CLAVE",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDatos("[a-zA-Z0-9]{4,20}",$admin_usuario)){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Su USUARIO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$admin_clave)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Su CLAVE no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    # Verificando administrador #
		    $check_admin=$this->ejecutarConsulta("SELECT * FROM usuario WHERE usuario_usuario='$admin_usuario' AND usuario_id='".$_SESSION['id']."'");
		    if($check_admin->rowCount()==1){

		    	$check_admin=$check_admin->fetch();

		    	if($check_admin['usuario_usuario']!=$admin_usuario || !password_verify($admin_clave,$check_admin['usuario_clave'])){

		    		$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"USUARIO o CLAVE de administrador incorrectos",
						"icono"=>"error"
					];
					return json_encode($alerta);
		        	exit();
		    	}
		    }else{
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"USUARIO o CLAVE de administrador incorrectos",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }


			# Almacenando datos#
			$nombreEmple = $this->limpiarCadena($_POST['nom_empleado']);
			$apellidoEmple = $this->limpiarCadena($_POST['ape_empleado']);
			$direccionEmple = $this->limpiarCadena($_POST['direccion']);
			$telefonoEmple = $this->limpiarCadena($_POST['telefono']);
			$tipoCargo = isset($_POST['id_cargos']) ? $this->limpiarCadena($_POST['id_cargos']) : NULL;

		    # Verificando campos obligatorios #
		    if($documentoEmple=="" || $nombreEmple==""|| $apellidoEmple==""|| $direccionEmple==""|| $telefonoEmple==""){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No has llenado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    # Verificando integridad de los datos $this->verificarDatos("[0-9]{0,40}", $tipoProve) || #
			if ($this->verificarDatos("[0-9]{3,40}", $documentoEmple) || 
				$this->verificarDatos("[0-9]{3,40}", $telefonoEmple) || 
				$this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombreEmple) || 
				$this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellidoEmple)) {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "El Empleado no coincide con el formato solicitado",
					"icono" => "error"
				];
				return json_encode($alerta);
				exit();
			}


            $empleado_datos_up=[
				/*[
					"campo_nombre" => "documento_NIT",
					"campo_marcador" => ":Documento",
					"campo_valor" => $documentoProve
				],*/
				[
					"campo_nombre" => "nom_empleado",
					"campo_marcador" => ":Nombre",
					"campo_valor" => $nombreEmple
				],
				[
					"campo_nombre" => "ape_empleado",
					"campo_marcador" => ":Apellido",
					"campo_valor" => $apellidoEmple
				],
				[
					"campo_nombre" => "direccion",
					"campo_marcador" => ":Direccion",
					"campo_valor" => $direccionEmple
				],
				[
					"campo_nombre" => "telefono",
					"campo_marcador" => ":Telefono",
					"campo_valor" => $telefonoEmple
				],
				[
					"campo_nombre" => "id_cargos",
					"campo_marcador" => ":Tipo",
					"campo_valor" => $tipoCargo
				],

			];

			$condicion=[
				"condicion_campo"=>"documento_emp",
				"condicion_marcador"=>":Documento",
				"condicion_valor"=>$documentoEmple
			];

			if($this->actualizarDatos("empleado", $empleado_datos_up, $condicion)){
				$alerta = [
					"tipo" => "recargar",
					"titulo" => "Empleado actualizado",
					"texto" => "Los datos del Empleado " . $nombreEmple ." ". $apellidoEmple . " se actualizaron correctamente",
					"icono" => "success"
				];
			} else {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "No hemos podido actualizar los datos del Empleado " . $nombreEmple . ", por favor intente nuevamente",
					"icono" => "error"
				];
			}

			return json_encode($alerta);
		}

		public function obtenerOpcionesCargo($busqueda = "") {
			$busqueda = $this->limpiarCadena($busqueda);
			
			if ($busqueda != "") {
				$consulta_datos = "SELECT * FROM cargos WHERE (id_cargos LIKE :busqueda OR tipo_cargo LIKE :busqueda) ORDER BY id_cargos ASC";
			} else {
				$consulta_datos = "SELECT * FROM cargos ORDER BY id_cargos ASC";
			}
			
			$stmt = $this->ejecutarConsulta($consulta_datos);
		
			if ($busqueda != "") {
				$stmt->bindValue(':busqueda', '%' . $busqueda . '%');
			}
			
			$stmt->execute();
		
			$datos = $stmt->fetchAll();
		
			$opciones = '';
			foreach ($datos as $row) {
				$opciones .= '<option value="' . htmlspecialchars($row['id_cargos']) . '">' . htmlspecialchars($row['tipo_cargo']) . '</option>';
			}
		
			// Devolver las opciones generadas
			return $opciones;
		}
		
		public function obtenerCargoActual($id_Cargo_actual = null) {
			$consulta_datos = "SELECT * FROM cargos  ORDER BY id_cargos ASC";
		
			$stmt = $this->ejecutarConsulta($consulta_datos);
			$stmt->execute();
			$datos = $stmt->fetchAll();
		
			$opciones = '';
		
			foreach ($datos as $row) {
				$selected = ($row['id_cargos'] == $id_Cargo_actual) ? 'selected' : '';
		
				$opciones .= '<option value="' . htmlspecialchars($row['id_cargos']) . '" ' . $selected . '>' . htmlspecialchars($row['tipo_cargo']) . '</option>';
			}
		
			return $opciones;
		}
	}