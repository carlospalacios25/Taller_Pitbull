<?php
	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\tsupplierController;

	if(isset($_POST['Modulo_Tipo_Proveedor'])){

		$tip_Porveedor = new tsupplierController();

		if($_POST['Modulo_Tipo_Proveedor']=="registrar"){
			echo $tip_Porveedor->registrarTproveedorControlador();
		}

		if($_POST['Modulo_Tipo_Proveedor']=="actualizar"){
			echo $tip_Porveedor->actualizarTproveedorControlador();
		}
		
	}else{
		session_destroy();
		header("Location: ".APP_URL."login/");
	}