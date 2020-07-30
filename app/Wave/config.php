<?php
	/**
	 * @autor Leonel Henriquez
	 */
	define('_SERVER_',$_SERVER['SERVER_NAME']);
	define('_SERVER_EXT_',__DEV_MODE__ ? 'http://'._SERVER_ : 'https://'._SERVER_);
	define('_S_HTTP_REFERER_',_SERVER_EXT_.$_SERVER['REQUEST_URI']);
	/*header('Access-Control-Allow-Origin: '._SERVER_EXT_);

	$_SERVER['HTTP_ORIGIN'] = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : _SERVER_EXT_;
	if(!($_SERVER['HTTP_ORIGIN']==_SERVER_EXT_ and $_SERVER['SERVER_NAME']==_SERVER_ and $_SERVER['SERVER_PORT']=='80')){
		exit();
	}*/

	define('_DIR_',_SERVER_EXT_.'/');
	define('__DIR_PROJECT__',__PATH_SOURCE__);
	define('__DIR_CONFIG__', __DIR_PROJECT__.'app/');
	define('__DIR_THEME__',__DIR_CONFIG__.'views/');
	define('__DIR_THEME_HEADER__',__DIR_THEME__.'header/');
	define('DEBUG', __DEV_MODE__);
	/*
	 * LIsta de base de datos soportadas
	 *
	 * Mysql: MYSQL
	 * PostgreSQL: POSTGRESQL
	 *
	 */
	define('__TYPE_DB__', 'MYSQL');
	define('__SERVER_DB__',	(__DEV_MODE__) ? 'localhost'	: 'localhost');
	define('__DB_NAME__',	(__DEV_MODE__) ? 'ysc' 			: 'ysc2');
	define('__USER_DB__',	(__DEV_MODE__) ? 'root'			: 'ysc_db');
	define('__PASS_DB__',	(__DEV_MODE__) ? 'root'			: '}li8L7(GorYr*nY~k{');

	error_reporting((DEBUG) ? E_ALL : 0);
	ini_set('display_errors', DEBUG);
	//log_errors(false);

	date_default_timezone_set('America/El_Salvador');
	define('_BETA_VERSION_',false);


	/*
	 * Pagadito Configuraciones
	 **/
	define("UID", (__DEV_MODE__) ? "93ee7fb653dd8c60a59e0be1364d8359" : "c1f3dc73d1c2f626cc8764786a8c99a5");
	define("WSK", (__DEV_MODE__) ? "5520384d8a1df6294f6c2380f7b77fe6" : "e6fd0218c5b9c02137ad8dce3cbd85ec");
	define("AMBIENTE_SANDBOX", __DEV_MODE__);
	//define()
	/*
	 * Fin configuraciones de Pagadito
	 **/


	//require_once __DIR_CONFIG__.'App.php';

	//$app = new wave\App();
