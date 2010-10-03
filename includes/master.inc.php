<?PHP
// Application flag
define('CLYDEPHP', true);

// Determine our absolute document root
define('DOC_ROOT', dirname(realpath(__FILE__)).'/../');

// Determine core spf-ng path
define('CLYDEPHP_ROOT', realpath(dirname(__FILE__)));

define('CLYDEPHP_VENDOR', DOC_ROOT."vendor/");

define('APP_ROOT', dirname(realpath($_SERVER["SCRIPT_FILENAME"])).'/');

// Global include files
require CLYDEPHP_ROOT . '/beans.inc.php';
require CLYDEPHP_ROOT . '/core.inc.php';
require CLYDEPHP_ROOT . '/functions.inc.php';
require CLYDEPHP_ROOT . '/compat.inc.php'; //some emulated function for php 5.1
require CLYDEPHP_ROOT . '/class.classloader.php';  // __autoload() is contained in this file


//register autoload function
spl_autoload_register("ClassLoader::autoload");

//add framework dir to classpath
addClasspath(CLYDEPHP_ROOT);

// Fix magic quotes
if(get_magic_quotes_gpc())
{
	$_POST    = fix_slashes($_POST);
	$_GET     = fix_slashes($_GET);
	$_REQUEST = fix_slashes($_REQUEST);
	$_COOKIE  = fix_slashes($_COOKIE);
}

//enable html exception handler
set_exception_handler('clydePhpExceptionHandler');

//if exists a file with custom boostrap
//include it
if (is_file(APP_ROOT."/bootstrap.inc.php")) {
	require APP_ROOT."/bootstrap.inc.php";
}

