<?php
	/**
	 * @autor Leonel Henriquez
	 * version 2.1
	 */
	/*
	 * Cambios en las versiones
	 * V1: Version inicial
	 * V2: - Se agrego soporte manual para la mayoria de caracteres especiales
	 * V2.1: - Se elimino este soporte sutiido por la funcion 'htmlentities' de php
	 */

	namespace Wave;

	class TextEncoder{

		private static $flags 		= ENT_HTML5;
		private static $encoding 	= "UTF-8";

		public static function text_encode($texto){
			return htmlentities($texto,self::$flags,self::$encoding);
		}
		public static function text_decode($texto){
			return html_entity_decode($texto,self::$flags,self::$encoding);
		}
	}
