<?php
	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\buysController;

	if(isset($_POST['Modulo_Compra'])){

		$compra = new buysController();

		if($_POST['Modulo_Compra']=="registrar"){
			echo $compra->registrarCompraControlador();
		}
		
	}else{
		session_destroy();
		header("Location: ".APP_URL."login/");
	}