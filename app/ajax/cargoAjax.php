<?php
	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\postController;

	if(isset($_POST['Modulo_Tipo_Cargo'])){

		$tip_Porveedor = new postController();

		if($_POST['Modulo_Tipo_Cargo']=="registrar"){
			echo $tip_Porveedor->registrarPostControlador();
		}

		if($_POST['Modulo_Tipo_Cargo']=="actualizar"){
			echo $tip_Porveedor->actualizarPostControlador();
		}
		
	}else{
		session_destroy();
		header("Location: ".APP_URL."login/");
	}