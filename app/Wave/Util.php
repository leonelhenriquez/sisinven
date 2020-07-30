<?php

	/**
	 * @autor Leonel Henriquez
	 * version 1.0
	 */

	namespace Wave;
	use \DateTime;

	class Util{
		public static function formatoFecha($format,$dia,$mes,$year){
			/*
				DD: para establecer el dia
				MM: para establecer el mes
				MMMM: para establece el mes numerico
				YY: para establecer el año
			*/
			$c_dia = str_replace('DD',$dia,$format);
			$c_mes_num = str_replace('MMMM',$mes,$c_dia);
			$c_mes = str_replace('MM',idioma($mes.'mes'),$c_mes_num);
			$c_res = str_replace('YY',$year,$c_mes);
			return $c_res;
		}
		public static function parseDateTime($dateTime = '0000-00-00 00:00:00',$format = "Y-m-d H:i:s"){
			return (new DateTime($dateTime))->format($format);
		}
		public static function parseHora($hora = '00:00:00',$format = 'h:i a'){
			/*if($hora=='00:00:00'){
				return '';
			}else{
				$hora = new DateTime($hora);
				return $hora->format($format);
			}*/
			return (new DateTime($hora))->format($format);
			//return ($hora=='00:00:00') ? '' : (DateTime::createFromFormat('H:i:s',$hora)->format($format));
		}
		public static function parseFecha($fecha = '0000-00-00',$format = 'Y-m-d',$hora = false){
			return (new DateTime($fecha))->format($format);
			//return ($fecha=='0000-00-00') ? '' : (DateTime::createFromFormat('Y-m-d',$fecha)->format($format));
			if ($fecha=='0000-00-00'){ 
				return '';
			}else{
				$date = DateTime::createFromFormat('Y-m-d',$fecha);
				$__retorno = explode(' ',strftime($format,$date->getTimestamp()));
				$__fecha = '';
				foreach ($__retorno as $key => $value) {
					if($value=='de'){
						$__fecha .= ' '.$value;
					}else{
						$__fecha .= ' '.ucwords($value);
					}
				}
				return $__fecha;
			}
		}
		public static function addTime($time,$time_add){
			//$starDate = new DateTime(date('Y').$mes.'-01');
			$Date = new DateTime($time);
			$Date->modify($time_add);
			return $Date->format('Y-m-d');
		}
		public static function detect($user_agent = ''){
			$$user_agent = ($user_agent=='') ? $_SERVER['HTTP_USER_AGENT'] : $user_agent;
			$browser=array("IE","OPERA","MOZILLA","NETSCAPE","FIREFOX","SAFARI","CHROME","MIDORI",/*"MOBILE",*/"CHROMIUM");
			$os=array("WIN","MAC","LINUX","UBUNTU","ANDROID","IPHONE","IPAD","WINDOWS PHONE");
			$mobil=array("MOBILE");
			# definimos unos valores por defecto para el navegador y el sistema operativo
			$info['browser'] = "OTHER";
			$info['os'] = "OTHER";
			$info['mobil'] = false;
			# buscamos el navegador con su sistema operativo
			foreach($browser as $parent){
				$s = strpos(strtoupper($user_agent), $parent);
				$f = $s + strlen($parent);
				$version = substr($user_agent, $f, 15);
				$version = preg_replace('/[^0-9,.]/','',$version);
				if ($s){
					$info['browser'] = ucfirst(strtolower($parent));
					$info['version'] = ucfirst(strtolower($version));
					if($info['browser']=="Ie"){
						$info['browser'] = "Internet Explorer";
					}
				}
			}
			# obtenemos el sistema operativo
			foreach($os as $val){
				if (strpos(strtoupper($user_agent),$val)!==false){
					$info['os'] = ucfirst(strtolower($val));
					if($info['os']=="Win"){
						$info['os'] = "Windows";
					}else if($info['os']=="Iphone"){
						$info['os'] = "iPhone";
					}else if($info['os']=="Ipad"){
						$info['os'] = "iPad";
					}
				}
			}
			# obtenemos el sistema operativo
			foreach($mobil as $val){
				if (strpos(strtoupper($user_agent),$val)!==false){
					$info['mobil'] = true;
				}
			}
			# devolvemos el array de valores
			return $info;
		}
		public static function string_decode($texto){
			return iconv("CP1252","UTF-8",$texto);
		}
		public static function string_encode($texto){
			return iconv("CP1252","UTF-8",$texto);
		}
		public static function getRealIP() {
			if (!empty($_SERVER['HTTP_CLIENT_IP'])){
				return $_SERVER['HTTP_CLIENT_IP'];
			}else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
				return $_SERVER['HTTP_X_FORWARDED_FOR'];
			}else{
				return $_SERVER['REMOTE_ADDR'];
			}
		}
	}