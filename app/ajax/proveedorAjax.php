<?php
	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\supplierController;

	if(isset($_POST['Modulo_Proveedor'])){

		$porveedor = new supplierController();

		if($_POST['Modulo_Proveedor']=="registrar"){
			echo $porveedor->registrarProveedorControlador();
		}

		if($_POST['Modulo_Proveedor']=="actualizar"){
			echo $porveedor->actualizarProveedorControlador();
		}
		
	}else{
		session_destroy();
		header("Location: ".APP_URL."login/");
	}