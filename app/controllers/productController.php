<?php
	/*Productos*/
	namespace app\controllers;
	use app\models\mainModel;
	use Exception;

	class productController extends mainModel{

		/*----------  Controlador registrar  ----------*/
		public function registrarProductoControlador(){
    		// Almacenando datos
			$nombrePro = $this->limpiarCadena($_POST['nom_producto']);
			$codigoPro = $this->limpiarCadena($_POST['codigo']);
			$descripcionPro = $this->limpiarCadena($_POST['descripcion']);
			$precioPro = $this->limpiarCadena($_POST['precio_unitario']);
			$existenciapro = $this->limpiarCadena($_POST['existencias']);
			
			// Verificando campos obligatorios
			if ($nombrePro == "" || $codigoPro == "" || $descripcionPro == "" || $precioPro == "" || $existenciapro == "") {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "No has llenado todos los campos que son obligatorios",
					"icono" => "error"
				];
				return json_encode($alerta);
			}

			// Verificando formato de datos
			if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,45}", $nombrePro) || 
				$this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,45}", $codigoPro) || 
				$this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,45}", $descripcionPro) || 
				$this->verificarDatos("[0-9]{0,40}", $precioPro) || 
				$this->verificarDatos("[0-9]{0,40}", $existenciapro)) {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "El Producto no coincide con el formato solicitado",
					"icono" => "error"
				];
				return json_encode($alerta);
			}

			// Verificando usuario
			$check_documentoPro = $this->ejecutarConsulta("SELECT nom_producto FROM producto WHERE 	nom_producto='$nombrePro'");
			if ($check_documentoPro->rowCount() > 0) {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "El Producto ingresado ya se encuentra registrado, por favor elija otro",
					"icono" => "error"
				];
				return json_encode($alerta);
			}

			// Datos a registrar
			$producto_reg = [
				[
					"campo_nombre" => "nom_producto",
					"campo_marcador" => ":NombreProducto",
					"campo_valor" => $nombrePro
				],
				[
					"campo_nombre" => "codigo",
					"campo_marcador" => ":Codigo",
					"campo_valor" => $codigoPro
				],
				[
					"campo_nombre" => "descripcion",
					"campo_marcador" => ":Descripcion",
					"campo_valor" => $descripcionPro
				],
				[
					"campo_nombre" => "precio_unitario",
					"campo_marcador" => ":Precio",
					"campo_valor" => $precioPro
				],
				[
					"campo_nombre" => "existencias",
					"campo_marcador" => ":Existencias",
					"campo_valor" => $existenciapro
				],
			];

			try {
				$registrar_producto = $this->guardarDatos("producto", $producto_reg);

				if ($registrar_producto->rowCount() == 1) {
					$alerta = [
						"tipo" => "limpiar",
						"titulo" => "Empleado registrado",
						"texto" => "El Producto ".$nombrePro. " fue creado con éxito",
						"icono" => "success"
					];
				} else {
					$alerta = [
						"tipo" => "simple",
						"titulo" => "Ocurrió un error inesperado",
						"texto" => "No se pudo registrar el Producto, por favor intente nuevamente",
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
		public function listarProductoControlador($pagina, $registros, $url, $busqueda) {

			$pagina = $this->limpiarCadena($pagina);
			$registros = $this->limpiarCadena($registros);
		
			$url = $this->limpiarCadena($url);
			$url = APP_URL . $url . "/";
		
			$busqueda = $this->limpiarCadena($busqueda);
			$tabla = "";
		
			$pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1;
			$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
		
			if (isset($busqueda) && $busqueda != "") {
				$consulta_datos = "SELECT * FROM producto WHERE (nom_producto LIKE '%$busqueda%' OR codigo LIKE '%$busqueda%') ORDER BY nom_producto ASC LIMIT $inicio, $registros";
				$consulta_total = "SELECT COUNT(id_producto) FROM producto	WHERE (nom_producto LIKE '%$busqueda%' OR codigo LIKE '%$busqueda%')";
			} else {
				$consulta_datos = "SELECT * FROM producto ORDER BY nom_producto ASC LIMIT $inicio, $registros";
				$consulta_total = "SELECT COUNT(nom_producto) FROM producto";
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
							<th class="has-text-centered">Nombre Producto</th>
							<th class="has-text-centered">Codigo</th>
							<th class="has-text-centered">Precio</th>
							<th class="has-text-centered">Stock</th>
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
							<td>' . $rows['nom_producto'] . '</td>
							<td>' . $rows['codigo']. '</td>
							<td>' . $rows['precio_unitario'] . '</td>
							<td>' . $rows['existencias'] . '</td>
							<td>
								<a href="' . APP_URL . 'productUpdate/' . $rows['id_producto'] . '/" class="button is-success is-rounded is-small">Actualizar</a>
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
				$tabla .= '<p class="has-text-right">Mostrando Productos  <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total . '</strong></p>';
		
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
			/*$tipoProve = isset($_POST['id_tipo_proveedor']) ? $this->limpiarCadena($_POST['id_tipo_proveedor']) : NULL;*/

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
					"texto" => "El proveedor no coincide con el formato solicitado",
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
				/*[
					"campo_nombre" => "id_tipo_proveedor",
					"campo_marcador" => ":Tipo",
					"campo_valor" => $tipoProve
				],*/

			];

			$condicion=[
				"condicion_campo"=>"documento_emp",
				"condicion_marcador"=>":Documento",
				"condicion_valor"=>$documentoEmple
			];

			if($this->actualizarDatos("empleado", $empleado_datos_up, $condicion)){
				$alerta = [
					"tipo" => "recargar",
					"titulo" => "Tipo proveedor actualizado",
					"texto" => "Los datos del proveedor " . $nombreEmple ." ". $apellidoEmple . " se actualizaron correctamente",
					"icono" => "success"
				];
			} else {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "No hemos podido actualizar los datos del proveedor " . $nombreEmple . ", por favor intente nuevamente",
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
		

	}