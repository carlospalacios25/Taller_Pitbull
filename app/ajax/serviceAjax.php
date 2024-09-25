<?php
	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\serviceController;

	if(isset($_POST['Modulo_Servicio'])){

		$servicio = new serviceController();

		if($_POST['Modulo_Servicio']=="registrar"){
			echo $servicio->registrarServicioControlador();
		}

		/*if($_POST['Modulo_Cliente']=="actualizar"){
			echo $porveedor->actualizarProveedorControlador();
		}*/
		
	}else{
		session_destroy();
		header("Location: ".APP_URL."login/");
	}