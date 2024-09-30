<?php
	
	namespace app\models;

	class viewsModel{

		/*---------- Modelo obtener vista ----------*/
		protected function obtenerVistasModelo($vista){

			$listaBlanca=["dashboard","userNew","userList","userUpdate","userSearch","userPhoto","logOut","tsupplierNew","tsupplierUpdate","supplierNew","supplierUpdate","customerNew","customerList","postNew","postUpdate","employeeNew","employeeUpdate","informationshop","productNew","productUpdate","serviceNew","servicepend","serviceUpdateEmpl","serviceclose","serviceUpdateClose","buysNew"];

			if(in_array($vista, $listaBlanca)){
				if(is_file("./app/views/content/".$vista."-view.php")){
					$contenido="./app/views/content/".$vista."-view.php"; 
				}else{
					$contenido="404";
				}
			}elseif($vista=="login" || $vista=="index"){
				$contenido="login";
			}else{
				$contenido="404";
			}
			return $contenido;
		}

	}