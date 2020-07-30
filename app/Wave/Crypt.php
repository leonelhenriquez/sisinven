<?php
	/*
	 * Encriptado de contraseña
	 * 
	 * Version 1.2
	 *
	 * @autor Leonel Henriquez
	 */

	namespace Wave;
	
	class Crypt{
		function pass_crypt($pass){
			$opciones = array('cost' => 12);
			$pass_crypt = substr(md5(rand(1000000,9999999)),1,7).substr(password_hash($pass,PASSWORD_BCRYPT,$opciones),7);

			$cc = '';
			$c_en = '';
			$rand = range(1,6);
			shuffle($rand);
			foreach ($rand as $val) {
				$cc .= $val;
			}
			$hash = $pass_crypt;
			for ($i=1; $i <=6 ; $i++) { 
				$clave[$i] = substr($hash,(($i*10)-10),10);
			}
			for ($i=1; $i <=6 ; $i++) {
				$c_en .= $clave[substr($cc,($i*1)-1,1)];
			}
			$pass_r = array('hash' => $c_en,'cc' => $cc);
			return $pass_r;
		}
		function pass_verify($pass,$hash,$cc = 123456){
			$result_pass_verify = false;
			for ($i=1; $i <=6; $i++) {
				$clave[substr($cc,($i*1)-1,1)] = substr($hash,(($i*10)-10),10);
			}
			$d_c = '';
			for ($dc=1; $dc <=6; $dc++) { 
				$d_c .= $clave[$dc];
			}
			$d_c = substr($d_c,7);
			if(password_verify($pass,('$2y$12$'.$d_c))) {
				$result_pass_verify = true;
			}
			return $result_pass_verify;
		}
		function generateUniId($i){
			$i = (int)$i;
			$unic = str_replace("/","-",crypt(sprintf("%u", crc32($i)),md5($i.($i*$i))));
			return str_replace(".","__",$unic);
		}
	}
