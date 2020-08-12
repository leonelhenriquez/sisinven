<?php
	/**
	 * @autor Leonel Henriquez
	 */
	ini_set('session.gc_maxlifetime',2147483647);
	ini_set('session.cookie_lifetime',2147483647);

	define('_SERVER_',$_SERVER['SERVER_NAME']);
	define('_SERVER_EXT_',__DEV_MODE__ ? 'http://'._SERVER_ : 'https://'._SERVER_);
	define('_S_HTTP_REFERER_',_SERVER_EXT_.$_SERVER['REQUEST_URI']);
	/*header('Access-Control-Allow-Origin: '._SERVER_EXT_);

	$_SERVER['HTTP_ORIGIN'] = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : _SERVER_EXT_;
	if(!($_SERVER['HTTP_ORIGIN']==_SERVER_EXT_ and $_SERVER['SERVER_NAME']==_SERVER_ and $_SERVER['SERVER_PORT']=='80')){
		exit();
	}*/

	define('_DIR_',_SERVER_EXT_.'/');
	define('__DIR_THEME__',__PATH_SOURCE__.'/src/views/');
	define('__DIR_THEME_HEADER__',__PATH_SOURCE__.'/src/');

	define('DEBUG', __DEV_MODE__);
	/*
	 * LIsta de base de datos soportadas
	 *
	 * Mysql: MYSQL 			- TypeDB::MYSQL
	 * PostgreSQL: POSTGRESQL 	- TypeDB::POSTGRESQL
	 *
	 */
	//define('__TYPE_DB__', TypeDB::MYSQL);
	define('__SERVER_DB__',	(__DEV_MODE__) ? 'localhost'	: 'localhost');
	define('__DB_NAME__',	(__DEV_MODE__) ? 'sisinv' 		: '');
	define('__USER_DB__',	(__DEV_MODE__) ? 'root'			: '');
	define('__PASS_DB__',	(__DEV_MODE__) ? 'root'			: '');

	error_reporting((DEBUG) ? E_ALL : 0);
	ini_set('display_errors', DEBUG);
	//log_errors(false);

	date_default_timezone_set('America/El_Salvador');	
