<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/5/18
 * Time: 23:25
 */
/**
 * 框架路由类
 *
 * @author iris
 */
namespace RainbowPHP\Core;
use App\Config\Config_middleware;
/**
 * @method static Router get(string $route, Callable $callback)
 * @method static Router post(string $route, Callable $callback)
 * @method static Router put(string $route, Callable $callback)
 * @method static Router delete(string $route, Callable $callback)
 * @method static Router options(string $route, Callable $callback)
 * @method static Router head(string $route, Callable $callback)
 */
class Router {
    public static $halts = false;
    public static $routes = array();
    public static $methods = array();
    public static $callbacks = array();
    public static $patterns = array(
        ':any' => '[^/]+',
        ':num' => '[0-9]+',
        ':all' => '.*'
    );
    public static $error_callback;

    /**
     * Defines a route w/ callback and method
     */
    public static function __callstatic($method, $params) {
        $uri = dirname($_SERVER['PHP_SELF']).'/'.$params[0];
        $uri= str_replace('\\', '', $uri);
        $callback = $params[1];

        array_push(self::$routes, $uri);
        array_push(self::$methods, strtoupper($method));
        array_push(self::$callbacks, $callback);
    }

    /**
     * Defines callback if route is not found
     */
    public static function error($callback) {
        self::$error_callback = $callback;
    }

    public static function haltOnMatch($flag = true) {
        self::$halts = $flag;
    }

    /**
     * Runs the callback for the given request
     */
    public static function dispatch(){
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        $searches = array_keys(static::$patterns);
        $replaces = array_values(static::$patterns);

        $found_route = false;
        self::$routes = str_replace('//', '/', self::$routes);

        // Check if route is defined without regex
        if (in_array($uri, self::$routes)) {
            $route_pos = array_keys(self::$routes, $uri);
            foreach ($route_pos as $route) {
                // Using an ANY option to match both GET and POST requests
                if (self::$methods[$route] == $method || self::$methods[$route] == 'ANY') {
                        $found_route = true;
                        echo '<br/>完全匹配路由佩佩完成<br/>';
                    var_dump(self::$callbacks[$route]);
                    if (self::$halts) return;

                    self::beforeControllerMiddleware(self::$callbacks[$route]);

                    self::runRoute(self::$callbacks[$route]);

                    self::afterControllerMiddleware(self::$callbacks[$route]);


                }
            }
        } else {
            // Check if defined with regex
            $pos = 0;
            foreach (self::$routes as $route) {
                if (strpos($route, ':') !== false) {
                    $route = str_replace($searches, $replaces, $route);
                }

                if (preg_match('#^' . $route . '$#', $uri, $matched)) {
                    if (self::$methods[$pos] == $method || self::$methods[$pos] == 'ANY') {
                        $found_route = true;

                        // Remove $matched[0] as [1] is the first parameter.
                        array_shift($matched);
                        self::beforeControllerMiddleware(self::$callbacks[$route]);

                        self::runRoute(self::$callbacks[$route],$matched);

                        self::afterControllerMiddleware(self::$callbacks[$route]);

                        if (self::$halts) return;

                    }
                }
                $pos++;
            }
        }

        // Run the error callback if the route was not found
        if ($found_route == false) {
            if (!self::$error_callback) {
                self::$error_callback = function() {
                    header($_SERVER['SERVER_PROTOCOL']." 404 Not Found");
                    echo '404';
                };
            } else {
                if (is_string(self::$error_callback)) {
                    self::get($_SERVER['REQUEST_URI'], self::$error_callback);
                    self::$error_callback = null;
                    self::dispatch();
                    return ;
                }
            }
            call_user_func(self::$error_callback);
        }
    }
    public static function descRoute($route)
    {
        if (!is_object($route)) {

            // Grab all parts based on a / separator
            $parts = explode('/',$route);

            // Collect the last index of the array
            $last = end($parts);

            // Grab the controller name and method call
            $segments = explode('@',$last);

            return $segments;

        }

    }
    public static function runRoute($route,$paramter=[])
    {

        if (!is_object($route)) {

            $segments = self::descRoute($route);

            // Instanitate controller
            $controller = new $segments[0]();

            // Call method
            if(!method_exists($controller, $segments[1])) {

                echo "类 and 方法 不匹配";
            }elseif(!$paramter){

                $controller->{$segments[1]}();

            }else{

                call_user_func_array(array($controller, $segments[1]), $paramter);

            }
        } else {
            // Call closure
            if(!$paramter){

                call_user_func($route);
            }else{

                call_user_func_array($route, $paramter);
            }

        }

    }
    public static function beforeControllerMiddleware($route)
    {
        $segments = self::descRoute($route);

        $middlewares = Config_middleware::$beforeController[$segments[0]];

        foreach($middlewares as $val){

            self::runRoute($val);
        }

    }

    public static function afterControllerMiddleware($route)
    {
        $segments = self::descRoute($route);

        $middlewares = Config_middleware::$afterController[$segments['0']];
        //$middlewares = Config_middleware::$afterController[$controller];

        foreach($middlewares as $val){

            self::runRoute($val);
        }

    }
}