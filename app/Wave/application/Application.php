<?php
	/**
	 * @autor Leonel Henriquez
	 *
	 * version 3.4
	 */

	namespace Wave\application;

	use Wave\GetUrl;
	use Wave\ListViews;
	use Wave\Crypt;
	use Wave\HttpVars;
	use Wave\Util;
	use Wave\User;

	use Wave\application\Session;
	use Wave\application\View;
	use Wave\Connection\DataBase;
	use Wave\Connection\event\ConnectionDatabaseEvent;
	use Wave\util\AppSettings;
	use Wave\language\Language;

	class Application{

		private $AppSettings;
		private $database;
		private $Session;
		private $language;
		private $HttpVars;
		private $listViews;
		public $GetUrl;

		public $Crypt;
		
		public $isMobile = false;


		function __construct(){
			global $_SERVER;
			global $_SESSION;
			$this->Session = new Session();
			$this->GetUrl = new GetUrl();
			$this->HttpVars = new HttpVars();

			$this->Crypt = new Crypt();
			$this->isMobile = false;
			if($this->HttpVars->isSetPost("device")){
				$this->isMobile = $this->HttpVars->post("device")=="6efdff5a2d6c84b5c9a7fee8f155f4355d27e6c66eadefc494bfad20901bda72";
			}
			$this->AppSettings = new AppSettings();
			$this->run();
		}

		public function run(){
			$this->initialLoad();
			
			date_default_timezone_set($this->getAppSettings()->getTimeZone());
			
			if($this->getAppSettings()->getUseDB()){
				$this->database = new DataBase(
					$this->getAppSettings()->getDBInfoConnection(),
					$this->getAppSettings()->geetEventDBConnection()
				);
			}
			if($this->getAppSettings()->getAppLangs()!==null && $this->getAppSettings()->getDefaultLanguage()!==null){
				$this->language = new Language($this->getAppSettings()->getAppLangs(),$this->getAppSettings()->getDefaultLanguage());
				
				$this->getLanguage()->setLanguage(
					$this->getAppSettings()->getLanguage()==null ? 
					$this->getAppSettings()->getDefaultLanguage() : 
					$this->getAppSettings()->getLanguage()
				);
			}
		}

		public function getAppSettings(): ?AppSettings{
			return $this->AppSettings;
		}

		public function getDatabase(): ?DataBase{
			return $this->database;
		}

		public function getSessionManager(): ?Session{
			return $this->Session;
		}

		public function getLanguage(): ?Language{
			return $this->language;
		}

		public function getHttpVars(): ?HttpVars{
			return $this->HttpVars;
		}

		public function initialLoad(){
		}
		public function getView($url){
			$view = new View();
			$view->setFile(__DIR__.'/default_error_view/Error404.php')
			->setTitulo("Error 404");
			return $view;
		}
		public function setError($error = ''){
			$view;
			switch ($error) {
				/*case 'ERROR_DB':
					break;
				case 'ERROR_JS':
					break;*/
				case 'ERROR_404':
						$view = new View();
						$view->setFile(__DIR__.'/default_error_view/Error404.php')
						->setTitulo("Error 404");
					break;
			}
			return $view;
		}
		function renderView(){
			global $_SERVER;
			$view = $this->getView($this->GetUrl);

			$useHeader = $view->isUseHeaders();
			
			//$this->isMobile = false;
			//if($this->HttpVars->isSetPost("device")){	
			//	$this->isMobile = $this->HttpVars->post("device")=="6efdff5a2d6c84b5c9a7fee8f155f4355d27e6c66eadefc494bfad20901bda72";
			//}
			$isHttpAjaxRequest = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
			if($view->isViewError()){
				$useHeader = !$isHttpAjaxRequest;
			}
			//$mobile = $view->isMobile();
			//$unic_mobile = $view->isUnicMobile();

			if(
				($view->isAjaxRequest() && !$isHttpAjaxRequest && !$view->isViewError() )
			){
				$view = $this->setError('ERROR_404');
			}

			//$headers = isset($view->isUseHeader()) ? $view->isUseHeader() : true;


			if($useHeader){
				require_once __DIR_THEME_HEADER__.'header/head.php';
			}

			if($view->isUseFile()){
				require $view->getFile();
			}else{
				$view->getContent()();
			}

			if($useHeader){
				require_once __DIR_THEME_HEADER__.'footer/footer.php';
			}
			$this->getDatabase()->Close();
		}

		public function getLangResource($rsc){
			if($rsc == null || $rsc == '' || $this->getAppSettings()->getAppLangs()==null || $this->getAppSettings()->getDefaultLanguage()==null){
				throw new Exception('The resource does not exist.');
			}
			return $this->getLanguage()->getString($rsc);
		}
	}