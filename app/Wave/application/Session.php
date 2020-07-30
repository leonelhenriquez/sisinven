<?php
	/*
	 * Modulo de manejo de sesiones
	 * Version: 1.0
	 *
	 * @author Leonel Henriquez
	 */
	namespace Wave\application;

	class Session{
		//public $__session_u_name = false;
		//public $Uniqid = '';
		protected $SessionIdentifier = 'id';
		private $__session_loged = false;
		function __construct(){
			$this->__start_session();
			$this->__user_session();
		}
		public function __start_session(){
			ini_set("session.cookie_httponly", 1);
			/*if(__DEV_MODE__){
				session_save_path(__PATH_SOURCE__.'session');
			}*/
			session_cache_limiter(false);
			session_name('web');
			session_cache_expire(false);
			session_start();

			global $_SESSION;

			$vrs = isset($_SESSION['vrs']) ? true : false;
			$user_session=isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
			
			if($user_session=='' && !$vrs){
				$id_sesion_antigua = session_id();
				session_regenerate_id();
			}
			$_SESSION['vrs'] = true;

		}
		public function destroyAll(){
			global $_SESSION;
			global $_SERVER;
			$this->__session_loged = false;
			$this->add($this->SessionIdentifier,null);
			
			session_unset();

			if (ini_get("session.use_cookies")) {
				$params = session_get_cookie_params();
				/*print_r(expression)(session_get_cookie_params());
				exit();*/
				/*setcookie(session_name(), '', time() - 42000,
					$params["path"], $params["domain"],
					$params["secure"], $params["httponly"]
				);*/
			}
			session_destroy();
			session_write_close();

		}

		public function add($name_session = '',$valor = ''){
			global $_SESSION;
			if($name_session!='' and $valor!=''){
				$_SESSION[$name_session] = $valor;
			}
		}

		public function get($name_session = ''){
			global $_SESSION;
			if($name_session!='' and $name_session!=' ' and isset($_SESSION[$name_session]) and $_SESSION[$name_session]!=''){
				return $_SESSION[$name_session];
			}else{
				return null;
			}
		}

		public function addSession($name_session = '',$valor = ''){
			$this->add($name_session,$valor);
		}
		public function __new_session($name_session = '',$valor = ''){
			$this->add($name_session,$valor);
		}
		
		public function getSession($name_session = ''){
			global $_SESSION;
			if($name_session!='' and $name_session!=' ' and isset($_SESSION[$name_session]) and $_SESSION[$name_session]!=''){
				return $_SESSION[$name_session];
			}else{
				return null;
			}
		}
		/*
		public function __call_session($name_session = ''){
			return $this->get($name_session);
		}*/
		/*public function __isset_session($name){
			return $this->isSetSession($name);
		}*/
		public function isSetSession($name){
			return ((null!=($this->get($name))) ? true : false);
		}
		public function __user_session(){
			$user_session = ($this->isSetSession($this->SessionIdentifier)) ? $this->get($this->SessionIdentifier) : null;
			$this->add('vrs',true);
			//$this->__session_u_name = $user_session;
			$this->__session_loged = $this->isSetSession($this->SessionIdentifier);
			return $user_session;
		}
		public function hasLogged(){
			return $this->__session_loged;
		}
	}