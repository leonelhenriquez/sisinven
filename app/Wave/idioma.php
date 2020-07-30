<?php
	/*
	 * Sin soporte, pospuesto para la version 5 del proyecto
	 */
	/* Obtiene el idioma del usuario */
	function IdiomaUsuario($user_data = ''){
		global $_SERVER;
		require_once __DIR_CONFIG__."idiomas/instalacion_de_idiomas.php";
		if ($user_data !='') {
			$si = $user_data;
		}else if(isset($_SERVER["HTTP_ACCEPT_LANGUAGE"])){
			$si = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,5);
		}else{
			$si = "es_SV";
			
		}
		if (isset($list_idioma[substr($si,0,2)][substr($si,3,5)])) {
			$res_idioma = substr($si,0,2).'_'.($list_idioma[substr($si,0,2)][substr($si,3,5)]);
		}elseif(isset($list_idioma[substr($si,0,2)]['defecto'])){
			$res_idioma = substr($si,0,2).'_'.($list_idioma[substr($si,0,2)]['defecto']);
		}else{
			$res_idioma = "es_SV";
		}
		return $res_idioma;
	}
	/* para obtener el pais nota: no es 100% fiable del resultado
	 * ya que el valor se obtinen del navegador y este puede ser cambiado por
	 * el usuario
	 */
	function Pais($tipo = ''){
		global $user_idioma_i;
		$cod_pais = substr($user_idioma_i,3,5);
		if($tipo == 'id'){
			global $connect_db;
			$sql = "SELECT * FROM paises WHERE codigo_pais = '".$cod_pais."'";
			$query_data_pais = $connect_db->query($sql);
			if($query_data_pais->num_rows>0){
				$data_pais = mysqli_fetch_array($query_data_pais);
				return $data_pais['id_pais'];
			}else{
				return '1';
			}
		}else{
			return $cod_pais;
		}
	}
	/*if($this->session->__session_loged){
		$user_idioma_i = (string) (IdiomaUsuario((String) ($this->user_data['idioma'])));
	}else{
		$user_idioma_i = (string) (IdiomaUsuario());
	}*/
	//$GLOBALS['user_idioma_i'] = $user_idioma_i;
	/*
	 * Carga el paquete de idoma por defecto siempre carga
	 * el paquete de idioma es_SV por si la traducciones no
	 * se an realizado completas y las convierte a array
	 */
	function obtenerArchivoIdioma($user_idioma){
		require_once __DIR_CONFIG__."idiomas/es/es_SV.php";
		$file_get = __DIR_CONFIG__."idiomas/".(substr($user_idioma,0,2))."/".(substr($user_idioma,0,2))."_".(substr($user_idioma,3,5)).".php";
		if ($user_idioma!="es_SV" and file_exists($file_get)){
			require_once $file_get;
			array_push(
				$idioma_in,
				$add_idioma
			);
		}
		return $idioma_in;
	}
	//$idioma_in = obtenerArchivoIdioma($user_idioma_i);
	$idioma_in = obtenerArchivoIdioma('es_SV');
	$GLOBALS['idioma_in'] = $idioma_in;
	/*
	 * Del paquete de idima cargado se da el resultado segun
	 * lo que se pida ejemplo:
	 * echo idioma('Iniciar sessión');
	 * si es en el paquete es_SV su resultado sera "Iniciar sessión"
	 * si es en el paquete en_EN su resultado sera "Login"
	 */
	function idioma($texto){
		global $idioma_in;
		global $user_idioma_i;
		if (isset($idioma_in["1"][$user_idioma_i][$texto])) {
			return $idioma_in["1"][$user_idioma_i][$texto];
		}else{
			return $idioma_in["0"]["es_SV"][$texto];
		}
	}