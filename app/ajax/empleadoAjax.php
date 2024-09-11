<?php
	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\employeeController;

	if(isset($_POST['Modulo_Empleado'])){

		$porveedor = new employeeController();

		if($_POST['Modulo_Empleado']=="registrar"){
			echo $porveedor->registrarEmpleadoControlador();
		}

		if($_POST['Modulo_Empleado']=="actualizar"){
			echo $porveedor->actualizarEmpleadoControlador();
		}
		
	}else{
		session_destroy();
		header("Location: ".APP_URL."login/");
	}