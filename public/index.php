<?php    
 	
	/** Define constant **/
	define('DS', DIRECTORY_SEPARATOR);
	define('ROOT', dirname(dirname(__FILE__)));
	/** Define constant directories **/
	define('LIBPATH', ROOT . DS . 'library' . DS);
	define('CONFPATH', ROOT . DS . 'conf' . DS);
	define('APPPATH', ROOT .DS . 'app' . DS);
	define('COREPATH', APPPATH . 'core' .DS);
	define('CNTRLPATH', APPPATH . 'controller' . DS);
	define('VWPATH', APPPATH . 'view' . DS);
	define('MDLPATH', APPPATH . 'models' . DS);

	/** Puts URL into variable **/ 
	$url = $_GET['url'];

	/** autoload **/
	require_once (COREPATH . 'bootstrap.php');