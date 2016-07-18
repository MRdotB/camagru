<?php

include 'RouterUtility.trait.php';

class Router {
	use RouterUtility;

	public static $routes = [];

	public static function __callstatic($method, $params) {
		$route = [
			'uri' => $params[0],
			'method' => strtoupper($method),
			'callback' => $params[1]
		];
		array_push(self::$routes, $route);
	}


	public static function dispatch(){
		$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		$method = $_SERVER['REQUEST_METHOD'];

		$action = RouterUtility::action(self::$routes, $uri, $method);
		if ($action['callback'] !== null) {
			call_user_func_array($action['callback'], $action['args']);
		} else {
			// todo
			echo 404;
		}
	}
}
