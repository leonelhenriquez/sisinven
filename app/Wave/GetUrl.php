<?php
	/**
	 * @autor Leonel Henriquez
	 * version 1.0
	 */
	namespace Wave;

	use Wave\ViewsUrl;

	class GetUrl /*extends ViewsUrl*/{
		//public $__total_urls;
		//public $__arrays_urlS;

		private $urlbase;
		private $url;
		private $listUrl;

		function __construct($urlbase = ''){
			//parent::__construct();
			$this->setUrlBase($urlbase);
			$this->init();
		}

		public function setUrlBase($urlbase){
			$this->urlbase = $urlbase;
		}

		public function getUrlBase(){
			return $this->urlbase;
		}
		public function getUrl(){
			return $this->url;
		}
		public function getListUrl(){
			return $this->listUrl;
		}

		private function init(){
			global $_SERVER;
			global $_POST;

			$_serverURI = $_SERVER['REQUEST_URI'];

			$get = (string) (parse_url($_serverURI, PHP_URL_QUERY));
			//$get = (isset($_POST['get_url']) and $_POST['get_url']!=='') ? ((string) (parse_url($_POST['get_url'], PHP_URL_QUERY))) : $get;
			$get = ($get=='') ? '' : ("?".$get);
			$request_url = substr($_serverURI,0,(strlen($_serverURI) - strlen($get)));
			$_SERVER['REQUEST_URI'] = $request_url;

			$urlText = "";
			$urls = array();
			$urls_server = explode("/",$request_url);
			$urls_base = explode("/",$this->getUrlBase());

			//$url[1] = ($url[1]=='') ? $this->ListViewsUrl[1] : $url[1];
			//if($url[count($url)-1]==''){
			//	unset($url[count($url)-1]);
			//}

			foreach ($urls_server as $key => $url) {
				if($url==""){
					unset($urls_server[$key]);
				}
			}
			foreach ($urls_base as $key => $url) {
				if($url==""){
					unset($urls_base[$key]);
				}
			}
			foreach ($urls_server as $key => $url) {
				foreach ($urls_base as $url_base) {
					if($url==$url_base){
						unset($urls_server[$key]);
					}
				}
			}
			$urlText = count($urls_server)==0 ? "/home" : "";
			if(count($urls_server)==0){
				array_push($urls, "home");
			}

			foreach ($urls_server as $url) {
				array_push($urls, $url);
				$urlText .='/'.$url;
			}

			$this->url = $urlText;;
			$this->listUrl = $urls;

			//$this->__arrays_urlS = $urls;
		}
		/*public function url($get_url = '',$view = ''){
			if($get_url=='' and $view=='ALL'){
				return $url = $this->__arrays_urlS;
			}else if($get_url!=''){
				$url = $this->__arrays_urlS;
				if(isset($url[$get_url])){
					return $url[$get_url];
				}else{
					return false;
				}
			}
		}
		public function __total_arrays_url(){
			return $this->size();
		}
		public function size(){
			$array_num = count($this->__arrays_urlS) - 1;
			$array_num = (empty($this->url($array_num))) ? ($array_num - 1) : $array_num;

			return $array_num;
		}*/
	}