<?php
	/*Proveedor*/
	namespace app\controllers;
	use app\models\mainModel;
	use Exception;

	class supplierController extends mainModel{

		/*----------  Controlador registrar  ----------*/
		public function registrarProveedorControlador(){
    		// Almacenando datos
			$documentoProve = $this->limpiarCadena($_POST['documento_NIT']);
			$nombreProve = $this->limpiarCadena($_POST['nom_proveedor']);
			$apellidoProve = $this->limpiarCadena($_POST['apellido_sociedad']);
			$direccionProve = $this->limpiarCadena($_POST['direccion']);
			$telefonoProve = $this->limpiarCadena($_POST['telefono']);
			$tipoProve = isset($_POST['id_tipo_proveedor']) ? $this->limpiarCadena($_POST['id_tipo_proveedor']) : NULL;

			// Verificando campos obligatorios
			if ($documentoProve == "" || $nombreProve == "" || $apellidoProve == "" || $direccionProve == "" || $telefonoProve == "" || $tipoProve == "") {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "No has llenado todos los campos que son obligatorios",
					"icono" => "error"
				];
				return json_encode($alerta);
			}

			// Verificando formato de datos
			if ($this->verificarDatos("[0-9]{3,40}", $documentoProve) || 
				$this->verificarDatos("[0-9]{3,40}", $telefonoProve) || 
				$this->verificarDatos("[0-9]{0,40}", $tipoProve) || 
				$this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombreProve) || 
				$this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellidoProve)) {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "El proveedor no coincide con el formato solicitado",
					"icono" => "error"
				];
				return json_encode($alerta);
			}

			// Verificando usuario
			$check_documentoPro = $this->ejecutarConsulta("SELECT documento_NIT FROM proveedor WHERE documento_NIT='$documentoProve'");
			if ($check_documentoPro->rowCount() > 0) {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "El PROVEEDOR ingresado ya se encuentra registrado, por favor elija otro",
					"icono" => "error"
				];
				return json_encode($alerta);
			}

			// Datos a registrar
			$proveedor_reg = [
				[
					"campo_nombre" => "documento_NIT",
					"campo_marcador" => ":Documento",
					"campo_valor" => $documentoProve
				],
				[
					"campo_nombre" => "nom_proveedor",
					"campo_marcador" => ":Nombre",
					"campo_valor" => $nombreProve
				],
				[
					"campo_nombre" => "apellido_sociedad",
					"campo_marcador" => ":Apellido",
					"campo_valor" => $apellidoProve
				],
				[
					"campo_nombre" => "direccion",
					"campo_marcador" => ":Direccion",
					"campo_valor" => $direccionProve
				],
				[
					"campo_nombre" => "telefono",
					"campo_marcador" => ":Telefono",
					"campo_valor" => $telefonoProve
				],
				[
					"campo_nombre" => "id_tipo_proveedor",
					"campo_marcador" => ":Tipo",
					"campo_valor" => $tipoProve
				],
			];

			try {
				$registrar_proveedor = $this->guardarDatos("proveedor", $proveedor_reg);

				if ($registrar_proveedor->rowCount() == 1) {
					$alerta = [
						"tipo" => "limpiar",
						"titulo" => "Proveedor registrado",
						"texto" => "El proveedor ".$nombreProve. " fue creado con éxito",
						"icono" => "success"
					];
				} else {
					$alerta = [
						"tipo" => "simple",
						"titulo" => "Ocurrió un error inesperado",
						"texto" => "No se pudo registrar el usuario, por favor intente nuevamente",
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
		/*----------  Controlador actualizar   ----------*/
		public function actualizarProveedorControlador(){

			$documentoProve=$this->limpiarCadena($_POST['documento_NIT']);

			# Verificando usuario #
		    $datos=$this->ejecutarConsulta("SELECT * FROM proveedor WHERE documento_NIT ='$documentoProve'");
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
			$nombreProve = $this->limpiarCadena($_POST['nom_proveedor']);
			$apellidoProve = $this->limpiarCadena($_POST['apellido_sociedad']);
			$direccionProve = $this->limpiarCadena($_POST['direccion']);
			$telefonoProve = $this->limpiarCadena($_POST['telefono']);
			/*$tipoProve = isset($_POST['id_tipo_proveedor']) ? $this->limpiarCadena($_POST['id_tipo_proveedor']) : NULL;*/

		    # Verificando campos obligatorios #
		    if($documentoProve=="" || $nombreProve==""|| $apellidoProve==""|| $direccionProve==""|| $telefonoProve==""){
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
			if ($this->verificarDatos("[0-9]{3,40}", $documentoProve) || 
				$this->verificarDatos("[0-9]{3,40}", $telefonoProve) || 
				$this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombreProve) || 
				$this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellidoProve)) {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "El proveedor no coincide con el formato solicitado",
					"icono" => "error"
				];
				return json_encode($alerta);
				exit();
			}


            $proveedor_datos_up=[
				/*[
					"campo_nombre" => "documento_NIT",
					"campo_marcador" => ":Documento",
					"campo_valor" => $documentoProve
				],*/
				[
					"campo_nombre" => "nom_proveedor",
					"campo_marcador" => ":Nombre",
					"campo_valor" => $nombreProve
				],
				[
					"campo_nombre" => "apellido_sociedad",
					"campo_marcador" => ":Apellido",
					"campo_valor" => $apellidoProve
				],
				[
					"campo_nombre" => "direccion",
					"campo_marcador" => ":Direccion",
					"campo_valor" => $direccionProve
				],
				[
					"campo_nombre" => "telefono",
					"campo_marcador" => ":Telefono",
					"campo_valor" => $telefonoProve
				],
				/*[
					"campo_nombre" => "id_tipo_proveedor",
					"campo_marcador" => ":Tipo",
					"campo_valor" => $tipoProve
				],*/

			];

			$condicion=[
				"condicion_campo"=>"documento_NIT",
				"condicion_marcador"=>":Documento",
				"condicion_valor"=>$documentoProve
			];

			if($this->actualizarDatos("proveedor", $proveedor_datos_up, $condicion)){
				$alerta = [
					"tipo" => "recargar",
					"titulo" => "Tipo proveedor actualizado",
					"texto" => "Los datos del proveedor " . $nombreProve . " se actualizaron correctamente",
					"icono" => "success"
				];
			} else {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "No hemos podido actualizar los datos del proveedor " . $nombreProve . ", por favor intente nuevamente",
					"icono" => "error"
				];
			}

			return json_encode($alerta);
		}

		public function obtenerOpcionesTipoProveedor($busqueda = "") {
			$busqueda = $this->limpiarCadena($busqueda);
			
			if ($busqueda != "") {
				$consulta_datos = "SELECT * FROM tipo_proveedor WHERE (tipo_proveedor LIKE :busqueda OR id_tipo_proveedor LIKE :busqueda) ORDER BY tipo_proveedor ASC";
			} else {
				$consulta_datos = "SELECT * FROM tipo_proveedor ORDER BY id_tipo_proveedor ASC";
			}
			
			$stmt = $this->ejecutarConsulta($consulta_datos);
		
			if ($busqueda != "") {
				$stmt->bindValue(':busqueda', '%' . $busqueda . '%');
			}
			
			$stmt->execute();
		
			$datos = $stmt->fetchAll();
		
			$opciones = '';
			foreach ($datos as $row) {
				$opciones .= '<option value="' . htmlspecialchars($row['id_tipo_proveedor']) . '">' . htmlspecialchars($row['tipo_proveedor']) . '</option>';
			}
		
			// Devolver las opciones generadas
			return $opciones;
		}
		

	}