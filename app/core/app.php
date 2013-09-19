<?php

/** Autoload **/
function __autoload($className) {
	if (file_exists(LIBPATH . strtolower($className) . '.class.php')) {
		require_once(LIBPATH . strtolower($className) . '.class.php');
	} else if (file_exists(CNTRLPATH . DS . strtolower($className) . '.php')) {
		require_once(CNTRLPATH . strtolower($className) . '.php');
	} else if (file_exists(MDLPATH . strtolower($className) . '.php')) {
		require_once(MDLPATH . strtolower($className) . '.php');
	} else {
		// Error code 
	}
}

/** Check if dev mode is on and display errors **/
function devMode() {
	if (DEV_MODE == true) {
		error_reporting(E_ALL);
		ini_set('display_errors','On');
	} else {
		error_reporting(E_ALL);
		ini_set('display_errors','Off');
		ini_set('log_errors', 'On');
		ini_set('error_log', ROOT.DS.'tmp'.DS.'logs'.DS.'error.log');
	}
}

/** Remove Magic Quotes **/
function stripSlash($value) {
	$value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
	return $value;
}

function delMQ() {
	if ( get_magic_quotes_gpc() ) {
		$_GET    = stripSlash($_GET   );
		$_POST   = stripSlash($_POST  );
		$_COOKIE = stripSlash($_COOKIE);
	}
}

/** Check register globals and remove them **/
function unregisterGlobals() {
	if (ini_get('register_globals')) {
		$array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
		foreach ($array as $value) {
			foreach ($GLOBALS[$value] as $key => $var) {
				if ($var === $GLOBALS[$key]) {
					unset($GLOBALS[$key]);
				}
			}
		}
	}
}

/** Main Call Function **/
function getUrl() {
	global $url;
	
	/** explode URL into an array **/
	$urlArray = array();
	$urlArray = explode("/",$url);
	
	$controller = $urlArray[0];
	array_shift($urlArray);
	$action = $urlArray[0];
	array_shift($urlArray);
	$queryString = $urlArray;

	$controllerName = $controller;
	$controller = ucwords($controller);
	$model = rtrim($controller, 's');
	$controller .= 'Controller';
	$dispatch = new $controller($model,$controllerName,$action);

	if ((int)method_exists($controller, $action)) {
		call_user_func_array(array($dispatch,$action),$queryString);
	} else {
		// Error code
	}
}



devMode();
delMQ();
unregisterGlobals();
getUrl();