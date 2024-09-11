<?php
	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\customerController;

	if(isset($_POST['Modulo_Cliente'])){

		$cliente = new customerController();

		if($_POST['Modulo_Cliente']=="registrar"){
			echo $cliente->registrarClienteControlador();
		}

		/*if($_POST['Modulo_Cliente']=="actualizar"){
			echo $porveedor->actualizarProveedorControlador();
		}*/
		
	}else{
		session_destroy();
		header("Location: ".APP_URL."login/");
	}