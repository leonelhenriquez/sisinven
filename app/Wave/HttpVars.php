<?php
	/**
	 *
	 * @autor: Leonel Henriquez
	 */
	namespace Wave;
	use Wave\TextEncoder;


	class HttpVars extends TextEncoder{
		public $POST;
		
		function __construct(){
			global $_POST;
			$this->POST = $this->_post_segure($_POST);
		}

		public function isSetPost($key){
			return isset($this->POST[$key]);
		}

		public function isSetGet($key){
			global $_GET;
			return (isset($_GET[$key]) and $_GET[$key]!='') ? true : false;
		}

		public function post($var,$is_array = false){
			return $this->POST[$var];
		}

		public function get($var,$type = 'encode'){
			global $_GET;
			return $this->text_encode(urldecode($_GET[$var]),$type);
		}

		public function _post_segure($var = null){
			if(isset($var)){
				if(is_array($var)){
					foreach ($var as $key => $value) {
						$var[$key] = $this->_post_segure($value);
					}
					return $var;
				}else{
					return TextEncoder::text_encode($var);
				}
			}
		}
	}