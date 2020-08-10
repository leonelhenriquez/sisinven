<?php
	namespace app;

	/*
	 * @autor Leonel Henriquez
	 * version: 1.0
	 */
	require_once __DIR__.'/autoload.php';
	require_once __DIR__.'/Wave/autoload.php';

	use app\{User,Proveedor};

	use Wave\application\Application;
	use Wave\application\View;
	use Wave\Connection\DBInfoConnection;
	use Wave\Connection\event\ConnectionDatabaseEvent;
	use Wave\Connection\TypeDB;
	use Wave\util\AppSettings;

	class App extends Application{
		public $UserData;
		public function initialLoad(){
			$this->getAppSettings()
				->setTimeZone('America/El_Salvador')
				->setUseDB(true)
				->setEventDBConnection(
					new class implements ConnectionDatabaseEvent{
						public function OnErrorConnection(){
							exit("Error Connection Database\n");
						}
					})
				->setDBInfoConnection(new DBInfoConnection(TypeDB::MYSQL,__SERVER_DB__,__USER_DB__,__PASS_DB__,__DB_NAME__));
				
		}
		function __construct(){
			parent::__construct();
			//$user = new User();


			if($this->getSessionManager()->hasLogged()){
				if($query = $this->getDatabase()->Query(

					sprintf("
						SELECT id_user, username, nombre, apellido, password_changed_date, empresa, IF(foto IS NULL,0,1) AS is_foto
							FROM users WHERE id_user = '%d'",
						$this->getSessionManager()->get("id"))
					)
				){
					$user_data_query = $this->getDatabase()->FetchArray($query);
					$this->UserData = new User();
					$this->UserData
						->setId($user_data_query["id_user"])
						->setUsername($user_data_query["username"])
						->setNombre($user_data_query["nombre"])
						->setApellido($user_data_query["apellido"])
						->setPasswordChangedDate($user_data_query["password_changed_date"])
						->setEmpresa($user_data_query["empresa"])
						->setFoto(
							($user_data_query["is_foto"]==1) 
								? _DIR_."image/{size}"
								: _DIR_."src/images/person-flat.png"
						);
					//print_r($user_data_query);
					//$this-UserData
					unset($user_data_query);
					$this->getDatabase()->free($query);
				}
			}
			$this->renderView();
		}

		public function getView($url){
			
			define("_DIR_FOLDERVIEW_MAIN_",__DIR__."/src/views/");
			define("_DIR_FOLDERVIEW_",__DIR__."/src/views/".($this->getSessionManager()->hasLogged() ? "1" : "0")."/");
			
			$view = new View();
			$view->setFile(_DIR_FOLDERVIEW_MAIN_."Error404.php")
			->setTitulo("Error 404")
			->setIsViewError(true);

			if(!$this->getSessionManager()->hasLogged()){
				switch ($url->getUrl()) {
					case '/':
					case '/home':
					case '/login':
							$view = new View();
							$view->setFile(_DIR_FOLDERVIEW_."login.php")
								->setTitulo("Iniciar sesión");
						break;
					case '/login/ais':
							$view = new View();
							$view->setFile(_DIR_FOLDERVIEW_."ais.php")
								->setUseHeaders(false)
								->setAjaxRequest(true);
						break;
				}
			}else{
				switch ($url->getUrl()) {
					case '/':
					case "/home":
							$view = new View();
							$view->setFile(_DIR_FOLDERVIEW_."home.php")
								->setTitulo("Inicio");
						break;
					case '/profile':
							$view = new View();
							$view->setFile(_DIR_FOLDERVIEW_."perfil.php")
								->setTitulo("Perfil");
						break;
					case "/profile/update_data":
							$view  = new View();
							$view->setFile(_DIR_FOLDERVIEW_."update_data.php")
								->setUseHeaders(false)
								->setAjaxRequest(true);
						break;
					case "/proveedores":
							$view = new View();
							$view->setFile(_DIR_FOLDERVIEW_."proveedores.php")
								->setTitulo("Proveedores");
						break;
					case '/proveedores/addproveedor':
							$view  = new View();
							$view->setFile(_DIR_FOLDERVIEW_."addproveedor.php")
								->setUseHeaders(false)
								->setAjaxRequest(true);
						break;
					case '/logout':
							$view = new View();
							$view->setFile(_DIR_FOLDERVIEW_."logout.php")
								->setTitulo("Perfil");
						break;
					case '/productos':
							$view = new View();
							$view->setFile(_DIR_FOLDERVIEW_."productos.php")
								->setTitulo("Productos");
						break;
					case '/productos/add':
							$view  = new View();
							$view->setFile(_DIR_FOLDERVIEW_."addproducto.php")
								->setUseHeaders(false)
								->setAjaxRequest(true);
						break;
					case '/productos/remove':
							$view  = new View();
							$view->setFile(_DIR_FOLDERVIEW_."removeproducto.php")
								->setUseHeaders(false)
								->setAjaxRequest(true);
						break;
					case '/productos/update':
							$view  = new View();
							$view->setFile(_DIR_FOLDERVIEW_."updateproducto.php")
								->setUseHeaders(false)
								->setAjaxRequest(true);
						break;
					case '/productos/get':
							$view  = new View();
							$view->setFile(_DIR_FOLDERVIEW_."getproducto.php")
								->setUseHeaders(false)
								->setAjaxRequest(true);
						break;
					case '/facturar':
							$view  = new View();
							$view->setFile(_DIR_FOLDERVIEW_."facturar.php")
								->setTitulo("Facturar");
						break;
					case '/facturar/new':
							$view  = new View();
							$view->setFile(_DIR_FOLDERVIEW_."newfactura.php")
								->setTitulo("Nueva factura");
						break;
					case '/facturar/new/save':
							$view  = new View();
							$view->setFile(_DIR_FOLDERVIEW_."savefactura.php")
								->setUseHeaders(false)
								->setAjaxRequest(true);
						break;
					
				}
				if($this->isSelectUrl('image')){
					$view  = new View();
					$view->setFile(_DIR_FOLDERVIEW_."image.php")
						->setUseHeaders(false);
				}
			}
			return $view;
		}

		public function isSelectUrl($page){
			return $this->GetUrl->getListUrl()[0]==$page;
		}

	}