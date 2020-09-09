<?php
	
	/*
	 * Version : 5.2020.09.09
	 *
	 * @author Leonel Henriquez
	 * (C) Leonel Henriquez
	 */

	header("Content-Type: text/html; charset=UTF-8");
	define('__DEV_MODE__', true);
	define('__PATH_SOURCE__', __DIR__.'/app');

	//var_dump(session_get_cookie_params());

	require_once __PATH_SOURCE__."/Config.php";
	require_once __PATH_SOURCE__."/App.php";
	

	
	(new app\App());
	


?>