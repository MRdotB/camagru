<?php
trait RouterUtility {
	public static function routes_search($routes, $uri, $method) {
		foreach ($routes as $route) {
			if ($route['uri'] === $uri && $route['method'] === $method) {
				return $route;
			}
		}
		return false;
	}

}

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
		$action = RouterUtility::routes_search(self::$routes, $uri, $method);

		if ($action === false) {
			echo 404;
			return ;
		}
		$action['callback']();
		var_dump($action);
	}

	public static function debug(){
		print_r(self::$routes);
	}

}
