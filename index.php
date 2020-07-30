<?php
	header("Content-Type: text/html; charset=UTF-8");
	define('__DEV_MODE__', true);
	define('__PATH_SOURCE__', __DIR__.'/app');


	//var_dump(session_get_cookie_params());
	//exit();

	require_once __PATH_SOURCE__."/Config.php";
	require_once __PATH_SOURCE__."/App.php";
	$app = new app\App();

	/*
	 * Version : 4.11.02.19
	 *
	 * @author Leonel Henriquez
	 * (C) Leonel Henriquez
	 */
	$app;
	unset($app);
?>