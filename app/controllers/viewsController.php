<?php

	namespace app\controllers;
	use app\models\viewsModel;

	class viewsController extends viewsModel{

		/*---------- Controlador obtener vistas ----------*/
		public function obtenerVistasControlador($vista) {
			if ($vista == "login") {
				return "login";
			}elseif($vista == "customerNew" ) {
				return "customerNew";
			}elseif($vista == "informationshop" ) {
				return "informationshop";
			}elseif($vista == "serviceNew" ) {
				return "serviceNew";
			}elseif ($vista != "") {
				return $this->obtenerVistasModelo($vista);
			}
		}
	}

    