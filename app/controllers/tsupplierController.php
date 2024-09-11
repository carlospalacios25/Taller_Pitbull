<?php
	/*Tipo Proveedor*/
	namespace app\controllers;
	use app\models\mainModel;
	use Exception;

	class tsupplierController extends mainModel{

		/*----------  Controlador registrar   ----------*/
		public function registrarTproveedorControlador(){

			# Almacenando datos#
		    $tipoProveedor=$this->limpiarCadena($_POST['tipo_proveedor']);
		    $tDescripcion=$this->limpiarCadena($_POST['descripcion']);


		    # Verificando campos obligatorios #
		    if($tipoProveedor=="" || $tDescripcion==""){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No has llenado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
			if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$tipoProveedor)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El Tipo de proveedor no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
            # Verificando usuario #
		    $check_tipoProveedor=$this->ejecutarConsulta("SELECT tipo_proveedor FROM tipo_proveedor WHERE tipo_proveedor='$tipoProveedor'");
		    if($check_tipoProveedor->rowCount()>0){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El TIPO DE PROVEEDOR ingresado ya se encuentra registrado, por favor elija otro",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		   

		    $tipo_Proveedor_reg=[
				[
					"campo_nombre"=>"tipo_proveedor",
					"campo_marcador"=>":Proveedor",
					"campo_valor"=>$tipoProveedor
				],
				[
					"campo_nombre"=>"descripcion",
					"campo_marcador"=>":Descripcion",
					"campo_valor"=>$tDescripcion
				],
			];

			try{				
				$registrar_tproveedor=$this->guardarDatos("tipo_proveedor",$tipo_Proveedor_reg);

				if($registrar_tproveedor->rowCount()==1){
					$alerta=[
						"tipo"=>"limpiar",
						"titulo"=>"Tipo Proveedor Registrado",
						"texto"=>"Tipo de proveedor ".$tipoProveedor." creado con exito",
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
		public function listarTproveedorControlador($pagina, $registros, $url, $busqueda) {

			$pagina = $this->limpiarCadena($pagina);
			$registros = $this->limpiarCadena($registros);
		
			$url = $this->limpiarCadena($url);
			$url = APP_URL . $url . "/";
		
			$busqueda = $this->limpiarCadena($busqueda);
			$tabla = "";
		
			$pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1;
			$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
		
			if (isset($busqueda) && $busqueda != "") {
				$consulta_datos = "SELECT * FROM tipo_proveedor WHERE (tipo_proveedor LIKE '%$busqueda%' OR id_tipo_proveedor LIKE '%$busqueda%') ORDER BY tproveedor ASC LIMIT $inicio, $registros";
				$consulta_total = "SELECT COUNT(id_tipo_proveedor) FROM tipo_proveedor WHERE (tipo_proveedor LIKE '%$busqueda%' OR id_tipo_proveedor LIKE '%$busqueda%')";
			} else {
				$consulta_datos = "SELECT * FROM tipo_proveedor ORDER BY tipo_proveedor ASC LIMIT $inicio, $registros";
				$consulta_total = "SELECT COUNT(id_tipo_proveedor) FROM tipo_proveedor";
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
							<th class="has-text-centered">Tipo Proveedor</th>
							<th class="has-text-centered">Descripcion</th>
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
							<td>' . $rows['tipo_proveedor'] . '</td>
							<td>' . $rows['descripcion'] . '</td>
							<td>
								<a href="' . APP_URL . 'tsupplierUpdate/' . $rows['id_tipo_proveedor'] . '/" class="button is-success is-rounded is-small">Actualizar</a>
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


		/*----------  Controlador actualizar  ----------*/
		public function actualizarTproveedorControlador(){

			$id=$this->limpiarCadena($_POST['id_tipo_proveedor']);

			# Verificando usuario #
		    $datos=$this->ejecutarConsulta("SELECT * FROM tipo_proveedor WHERE id_tipo_proveedor='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el usuario en el sistema",
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
		    $tporveedor=$this->limpiarCadena($_POST['tipo_proveedor']);
		    $tDescripcion=$this->limpiarCadena($_POST['descripcion']);

		    # Verificando campos obligatorios #
		    if($tporveedor=="" || $tDescripcion==""){
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
		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$tporveedor)){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El NOMBRE no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }


            $tproveedor_datos_up=[
				[
					"campo_nombre"=>"tipo_proveedor",
					"campo_marcador"=>":Proveedor",
					"campo_valor"=>$tporveedor
				],
				[
					"campo_nombre"=>"descripcion",
					"campo_marcador"=>":Descripcion",
					"campo_valor"=>$tDescripcion
				],
			];

			$condicion=[
				"condicion_campo"=>"id_tipo_proveedor",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("tipo_proveedor", $tproveedor_datos_up, $condicion)){
				$alerta = [
					"tipo" => "recargar",
					"titulo" => "Tipo proveedor actualizado",
					"texto" => "Los datos del tipo proveedor " . $tporveedor . " se actualizaron correctamente",
					"icono" => "success"
				];
			} else {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "No hemos podido actualizar los datos del tipo proveedor " . $tporveedor . ", por favor intente nuevamente",
					"icono" => "error"
				];
			}

			return json_encode($alerta);
		}

		
	}