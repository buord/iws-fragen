<?php

// Inspired by:
// https://steampixel.de/einfaches-und-elegantes-url-routing-mit-php/

class Route {

	private static $routes = [];
	private static $path_not_found = null;
	private static $method_not_allowed = null;
	
	public static function add($expression, $function, $method = 'get') {
		array_push(self::$routes, compact('expression', 'function', 'method'));
	}

	public static function path_not_found($function) {
		self::$path_not_found = $function;
	}

	public static function method_not_allowed($function) {
		self::$method_not_allowed = $function;
	}

	public static function run($basepath = '/') {
		$parsed_url = parse_url($_SERVER['REQUEST_URI']);

		if (isset($parsed_url['path'])) {
			$path = $parsed_url['path'];
		} else {
			$path = '/';
		}

		$method = $_SERVER['REQUEST_METHOD'];
		$path_match_found = false;
		$route_match_found = false;

		foreach (self::$routes as $route) {
			if ($basepath != '' && $basepath != '/') {
				$route['expression'] = '(' . $basepath . ')' . $route['expression'];
			}

			$route['expression'] = '^' . $route['expression'] . '$';

			if (preg_match('#' . $route['expression'] . '#', $path, $matches)) {

				$path_match_found = true;

				if (strtolower($method) == strtolower($route['method'])) {
					array_shift($matches);

					if ($basepath != '' && $basepath != '/') {
						array_shift($matches);
					}

					$function = $route['function'];

					if (!is_callable($function) && strpos($function, '@') !== false) {
						list($function, $method) = explode('@', $function);
					}

					self::call_function($function, $matches, $method);

					$route_match_found = true;

					break;
				}
			}
		}

		if (!$route_match_found) {
			if ($path_match_found) {
				header("HTTP/1.0 405 Method Not Allowed");

				if (self::$method_not_allowed) {
					call_user_func_array(self::$method_not_allowed, [$path, $method]);
				}
			} else {
				header("HTTP/1.0 404 Not Found");

				if (self::$path_not_found) {
					call_user_func_array(self::$path_not_found, [$path]);
				}
			}
		}
	}

	private static function call_function($function, $arguments, $method = 'get') {

		if (is_callable($function)) {
			call_user_func_array($function, $arguments);
		} else if (is_string($function)) {

			require_once "../app/Controllers/$function.php";

			$controller = new $function;

            call_user_func_array([$controller, $method], $arguments);
		}
	}
}
