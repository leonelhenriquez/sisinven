<?php
	/**
	 * Versión: 1.0
	 * 
	 * @autor Leonel Henriquez
	 *
	 * Clases Necesarias
	 * -- Wave Sesssion >= 1.0
	 */
	namespace Wave;

	
	class ListViews{

		public $ListViewsInfo;
		public $ListViewsUrl;
		public $ListViews;

		function __construct($root){
			$this->ListViewsUrl = $root->GetUrl->ListViewsUrl;
			$this->ListViews = $this->getListViews($root->getSessionManager()->hasLogged());
		}
		public function getListViews($status_sesion = false){
			$control_url = $this->ListViewsUrl;
			if($status_sesion){
				require __PATH_SOURCE__.'/pags_info/1.php';
			}else{
				require __PATH_SOURCE__.'/pags_info/0.php';
			}
			return $pag_requi;
		}
		public function IssetPage($url){
			if(isset($this->ListViews[$url])){
				return true;
			}else{
				return false;
			}
		}
		public function getViewInfo($url){
			if($this->IssetPage($url)){
				return $this->ListViews[$url];
			}
		}
	}