<?php
	/*Cliente*/
	namespace app\controllers;
	use app\models\mainModel;
	use Exception;

	class customerController extends mainModel{

		/*----------  Controlador registrar  ----------*/
		public function registrarClienteControlador(){
    		// Almacenando datos
			$cedulaCli = $this->limpiarCadena($_POST['cedula']);
			$nomCloente = $this->limpiarCadena($_POST['nom_cliente']);
			$apeCliente = $this->limpiarCadena($_POST['ape_cliente']);
			$telCliente = $this->limpiarCadena($_POST['telefono']);
			$dirCliente = $this->limpiarCadena($_POST['direccion']);
			
			// Verificando campos obligatorios
			if ($cedulaCli == "" || $nomCloente == "" || $apeCliente == "" || $telCliente == "" || $dirCliente == "") {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "No has llenado todos los campos que son obligatorios",
					"icono" => "error"
				];
				return json_encode($alerta);
			}

			// Verificando formato de datos
			if ($this->verificarDatos("[0-9]{3,40}", $cedulaCli) || 
				$this->verificarDatos("[0-9]{3,40}", $telCliente) || 
				$this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nomCloente) || 
				$this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apeCliente)) {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "El cliente no coincide con el formato solicitado",
					"icono" => "error"
				];
				return json_encode($alerta);
			}

			// Verificando usuario
			$check_documentoCli = $this->ejecutarConsulta("SELECT cedula FROM cliente WHERE cedula='$cedulaCli'");
			if ($check_documentoCli->rowCount() > 0) {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Cliente Registrado",
					"texto" => "Ya te encuentras Registrado, ya Puedes aceder a nuestros servicos",
					"icono" => "error"
				];
				return json_encode($alerta);
			}

			// Datos a registrar
			$cliente_reg = [
				[
					"campo_nombre" => "cedula",
					"campo_marcador" => ":cedula",
					"campo_valor" => $cedulaCli
				],
				[
					"campo_nombre" => "nom_cliente",
					"campo_marcador" => ":Nombre",
					"campo_valor" => $nomCloente
				],
				[
					"campo_nombre" => "ape_cliente",
					"campo_marcador" => ":Apellido",
					"campo_valor" => $apeCliente
				],
				[
					"campo_nombre" => "telefono",
					"campo_marcador" => ":Telefono",
					"campo_valor" => $telCliente
				],
				[
					"campo_nombre" => "direccion",
					"campo_marcador" => ":Direccion",
					"campo_valor" => $dirCliente
				],
			];

			try {
				$registrar_cliente = $this->guardarDatos("cliente", $cliente_reg);

				if ($registrar_cliente->rowCount() == 1) {
					$alerta = [
						"tipo" => "limpiar",
						"titulo" => "Cliente registrado",
						"texto" => "Bienvenido ".$nomCloente. ", puedes aceder a nuestros servicios",
						"icono" => "success"
					];
				} else {
					$alerta = [
						"tipo" => "simple",
						"titulo" => "Ocurrió un error inesperado",
						"texto" => "No se pudo registrar, por favor intente nuevamente",
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
		public function listarClienteControlador($pagina, $registros, $url, $busqueda) {

			$pagina = $this->limpiarCadena($pagina);
			$registros = $this->limpiarCadena($registros);
		
			$url = $this->limpiarCadena($url);
			$url = APP_URL . $url . "/";
		
			$busqueda = $this->limpiarCadena($busqueda);
			$tabla = "";
		
			$pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1;
			$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
		
			if (isset($busqueda) && $busqueda != "") {
				$consulta_datos = "SELECT * FROM cliente WHERE (cedula LIKE '%$busqueda%' OR nom_proveedor LIKE '%$busqueda%') ORDER BY cedula ASC LIMIT $inicio, $registros";
				$consulta_total = "SELECT COUNT(cedula) FROM cliente WHERE (cedula LIKE '%$busqueda%' OR cedula LIKE '%$busqueda%')";
			} else {
				$consulta_datos = "SELECT * FROM cliente ORDER BY cedula ASC LIMIT $inicio, $registros";
				$consulta_total = "SELECT COUNT(cedula) FROM cliente";
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
							<th class="has-text-centered">cedula</th>
							<th class="has-text-centered">Nombre Completo</th>
							<th class="has-text-centered">Direccion</th>
							<th class="has-text-centered">Telefono</th>
							<!--<th class="has-text-centered" colspan="3">Opciones</th>-->
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
							<td>' . $rows['cedula'] . '</td>
							<td>' . $rows['nom_cliente'] . ' '.$rows['ape_cliente'].'</td>
							<td>' . $rows['direccion'] . '</td>
							<td>' . $rows['telefono'] . '</td>
							<!--<td>
								<a href="' . APP_URL . 'customerUpdate/' . $rows['cedula'] . '/" class="button is-success is-rounded is-small">Actualizar</a>
							</td>-->
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
				$tabla .= '<p class="has-text-right">Mostrando Cliente <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total . '</strong></p>';
		
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

	}