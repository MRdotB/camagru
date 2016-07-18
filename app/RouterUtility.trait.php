<?php
trait RouterUtility {
	private static function array_cmp_skip($uri_ref, $uri_arg, $index) {
		if (count($uri_ref) !== count($uri_arg)) {
			return false;
		}
		for ($i = 1; $i < count($uri_ref); $i++) {
			if ($uri_ref[$i] !== $uri_arg[$i] && $i !== $index) {
				return false;
			}
		}
		return true;
	}

	public static function action($routes, $uri, $method) {
		$action = [
			'callback' => null,
			'args' => []
		];
		// check simple routes
		foreach ($routes as $route) {
			if ($route['method'] === $method && $route['uri'] === $uri) {
				$action['callback'] = $route['callback'];
				return $action;
			}
		}
		// regex routes
		$uri_arg = explode('/', $uri);
		foreach ($routes as $route) {
			if ($route['method'] === $method) {
				$uri_ref = explode('/', $route['uri']);
				if ($index = array_search(':id', $uri_ref)) {
					if (self::array_cmp_skip($uri_ref, $uri_arg, $index)) {
						if (preg_match('/[0-9]+/', $uri_arg[$index])) {
							$action['callback'] = $route['callback'];
							$action['args'][] = $uri_arg[$index];
							return $action;
						}
					}
				} else if ($index = array_search(':any', $uri_ref)) {
					if (self::array_cmp_skip($uri_ref, $uri_arg, $index)) {
						if (preg_match('/.*/', $uri_arg[$index])) {
							$action['callback'] = $route['callback'];
							$action['args'][] = $uri_arg[$index];
							return $action;
						}
					}
				}
			}
		}
	}
}
