<?php
	/**
	 * Manejo de las URL's de la pagina
	 * Versión: 2.0
	 *
	 * @autor: Leonel Henriquez
	 */
	namespace Wave;
	class ViewsUrl{
		public $ListViewsUrl;
		public function __construct(){
			$this->ListViewsUrl = $this->getListViewsUrl();
		}
		public function getListViewsUrl(){
			return array(
				1  => 'home',
				2  => 'login',
				3  => 'singup',
				4  => 'ais',//autenticación de inicio de sesion
				6  => 'adduser',
				7  => 'tablero',
				8  => 'logout',
				10 => 'profile',
				12 => 'payment',
				13 => 'paymentr',
				15 => 'update_data',
				17 => 'image',
				18 => 'productos',
				19 => 'image_producto',
				20 => 'precompra',
				21 => 'donar'
			);
		}
		public function __isset_url($num_url = '',$perfil_list = false){
			if ($num_url!=0 and $perfil_list==false and isset($this->___url[$num_url])){
				return true;
			}else if($num_url!=0 and $perfil_list==true and isset($this->___url_profile[$num_url])){
				return true;
			}else{
				return false;
			}
		}
	}