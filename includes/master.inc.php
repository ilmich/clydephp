<?php

	// Application flag
	define('CLYDEPHP', true);
	
	// Framework version
	define('CLYDEPHP_VERSION', '0.1.0rc1');
	
	// Determine our absolute document root
	define('DOC_ROOT', dirname(realpath(__FILE__)).'/../');
	
	// Determine core spf-ng path
	define('CLYDEPHP_ROOT', realpath(dirname(__FILE__)));
	
	define('CLYDEPHP_VENDOR', DOC_ROOT.'vendor/');
	
	define('APP_ROOT', dirname(realpath($_SERVER['SCRIPT_FILENAME'])).'/');
	
	// Global include files
	require CLYDEPHP_ROOT . '/beans.inc.php';
	require CLYDEPHP_ROOT . '/core.inc.php';
	require CLYDEPHP_ROOT . '/functions.inc.php';
	require CLYDEPHP_ROOT . '/compat.inc.php'; //some emulated function	
	require CLYDEPHP_ROOT . '/splclassloader.php';
	
	
	//setup base classloader
	$classLoader = SplClassLoader::getInstance();
	$classLoader->add('clydephp', CLYDEPHP_ROOT);
	$classLoader->register(true);
	
	use utils\Strings;
	
	// Fix magic quotes
	if(get_magic_quotes_gpc())
	{
		$_POST    = Strings::fixSlashes($_POST);
		$_GET     = Strings::fixSlashes($_GET);
		$_REQUEST = Strings::fixSlashes($_REQUEST);
		$_COOKIE  = Strings::fixSlashes($_COOKIE);
	}
	
	//enable html exception handler
	if (!isset($_ENV['SHELL']))
		set_exception_handler('clydePhpExceptionHandler');
	
	//if exists a file with custom boostrap
	//include it
	if (is_file(APP_ROOT.'/bootstrap.inc.php')) {
		require APP_ROOT.'/bootstrap.inc.php';
	}

