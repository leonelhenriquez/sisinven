<?php
	if (version_compare(PHP_VERSION, '7.1','<')) {
		throw new Exception('Se require una version de PHP  mayor o igual a 7.1 la version actual que usa es '.PHP_VERSION);
	}

	spl_autoload_register(function ($class) {
		//echo $class."\n";
		// project-specific namespace prefix
		$prefix = 'Wave\\';

		// base directory for the namespace prefix
		$base_dir = __DIR__.'/';

		// does the class use the namespace prefix?
		$len = strlen($prefix);
		if (strncmp($prefix, $class, $len) !== 0) {
			// no, move to the next registered autoloader
			return;
		}

		// get the relative class name
		$relative_class = substr($class, $len);

		// replace the namespace prefix with the base directory, replace namespace
		// separators with directory separators in the relative class name, append
		// with .php
		$file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

		//echo $file."\n\n\n\n";
		// if the file exists, require it
		if (file_exists($file)) {
			require_once $file;
		}
	});