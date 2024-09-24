<?php
	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\productController;

	if(isset($_POST['Modulo_Producto'])){

		$producto = new productController();

		if($_POST['Modulo_Producto']=="registrar"){
			echo $producto->registrarProductoControlador();
		}

		/*if($_POST['Modulo_Empleado']=="actualizar"){
			echo $porveedor->actualizarEmpleadoControlador();
		}*/
		
	}else{
		session_destroy();
		header("Location: ".APP_URL."login/");
	}