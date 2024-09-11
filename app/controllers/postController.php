<?php
	/*Tipo Cargo*/
	namespace app\controllers;
	use app\models\mainModel;
	use Exception;

	class postController extends mainModel{

		/*----------  Controlador registrar   ----------*/
		public function registrarPostControlador(){

			# Almacenando datos#
		    $cargo=$this->limpiarCadena($_POST['tipo_cargo']);

		    # Verificando campos obligatorios #
		    if($cargo==""){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No has llenado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
			
            # Verificando usuario #
		    $check_cargo=$this->ejecutarConsulta("SELECT tipo_cargo FROM cargos WHERE tipo_cargo='$cargo'");
		    if($check_cargo->rowCount()>0){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El CARGO ".$cargo." ingresado ya se encuentra registrado, por favor elija otro",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
		    $cargo_reg=[
				[
					"campo_nombre"=>"tipo_cargo",
					"campo_marcador"=>":tipo_cargo",
					"campo_valor"=>$cargo
				],
			];

			try{				
				$registrar_cargo=$this->guardarDatos("cargos",$cargo_reg);

				if($registrar_cargo->rowCount()==1){
					$alerta=[
						"tipo"=>"limpiar",
						"titulo"=>"Cargo Registrado",
						"texto"=>"El cargo ".$cargo_reg." creado con exito",
						"icono"=>"success"
					];
				}else{

					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"No se pudo registrar el usuario, por favor intente nuevamente",
						"icono"=>"error"
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
		public function listarPostControlador($pagina, $registros, $url, $busqueda) {

			$pagina = $this->limpiarCadena($pagina);
			$registros = $this->limpiarCadena($registros);
		
			$url = $this->limpiarCadena($url);
			$url = APP_URL . $url . "/";
		
			$busqueda = $this->limpiarCadena($busqueda);
			$tabla = "";
		
			$pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1;
			$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
		
			if (isset($busqueda) && $busqueda != "") {
				$consulta_datos = "SELECT * FROM cargos WHERE (id_cargos LIKE '%$busqueda%' OR tipo_cargo LIKE '%$busqueda%') ORDER BY tipo_cargo ASC LIMIT $inicio, $registros";
				$consulta_total = "SELECT COUNT(id_cargos) FROM cargos WHERE (id_cargos LIKE '%$busqueda%' OR tipo_cargo LIKE '%$busqueda%')";
			} else {
				$consulta_datos = "SELECT * FROM cargos ORDER BY tipo_cargo ASC LIMIT $inicio, $registros";
				$consulta_total = "SELECT COUNT(id_cargos) FROM cargos";
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
							<th class="has-text-centered">Cargo</th>
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
							<td>' . $rows['tipo_cargo'] . '</td>
							<td>
								<a href="' . APP_URL . 'postUpdate/' . $rows['id_cargos'] . '/" class="button is-success is-rounded is-small">Actualizar</a>
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
				$tabla .= '<p class="has-text-right">Mostrando cargo <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total . '</strong></p>';
		
				$tabla .= $this->paginadorTablas($pagina, $numeroPaginas, $url, 10);
			}
		
			return $tabla;
		}

		/*----------  Controlador actualizar  ----------*/
		public function actualizarPostControlador(){

			$id=$this->limpiarCadena($_POST['id_cargos']);

			# Verificando usuario #
		    $datos=$this->ejecutarConsulta("SELECT * FROM cargos WHERE 	id_cargos='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el cargo en el sistema",
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
		    $tcargo=$this->limpiarCadena($_POST['tipo_cargo']);

		    # Verificando campos obligatorios #
		    if($tcargo==""){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No has llenado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    # Verificando integridad de los datos #
		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$tcargo)){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El CARGO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }


            $tcargos_datos_up=[
				[
					"campo_nombre"=>"tipo_cargo",
					"campo_marcador"=>":tipo_cargo",
					"campo_valor"=>$tcargo
				],
			];

			$condicion=[
				"condicion_campo"=>"id_cargos",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("cargos", $tcargos_datos_up, $condicion)){
				$alerta = [
					"tipo" => "recargar",
					"titulo" => "Tipo proveedor actualizado",
					"texto" => "Los datos del cargo " . $tcargo . " se actualizaron correctamente",
					"icono" => "success"
				];
			} else {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "No hemos podido actualizar los datos del cargo " . $tcargo . ", por favor intente nuevamente",
					"icono" => "error"
				];
			}

			return json_encode($alerta);
		}

		
	}