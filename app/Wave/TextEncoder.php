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
		function text_encode($texto){
			return htmlentities($texto);
		}
	}
