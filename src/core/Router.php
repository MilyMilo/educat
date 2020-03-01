<?php

namespace App\Core;


class Router
{
    protected $routes = [
        'GET' => [],
        'POST' => []
    ];

    /**
     * Direct the request to respective handler within controller
     * Render a 404 error page a controller can't be found
     * 
     * @param string $uri Requested URI
     * @param string $request_type Request method
     */
    public function direct($uri, $request_type)
    {
        if (array_key_exists($uri, $this->routes[$request_type])) {
            return $this->call_action(
                ...explode('@', $this->routes[$request_type][$uri])
            );
        }

        Router::display_404($uri);
    }

    /**
     * Initialize router by reading the routes file
     * 
     * @param string $routes_file Path to the routes file
     */
    public static function load($routes_file)
    {
        $router = new static;
        require($routes_file);
        return $router;
    }

    /**
     * Register a GET request handler
     * 
     * @param string $uri URI to be handled
     * @param string $controller Name of Controller and it's handling action
     */
    public function get($uri, $controller)
    {
        $this->routes['GET'][$uri] = $controller;
    }

    /**
     * Register a POST request handler
     * 
     * @param string $uri URI to be handled
     * @param string $controller Name of Controller and it's handling action
     */
    public function post($uri, $controller)
    {
        $this->routes['POST'][$uri] = $controller;
    }


    /**
     * Render a 404 Not Found page
     * 
     * @param string $uri URI That wasn't found
     */
    public static function display_404($uri)
    {
        return view('404', compact('uri'));
    }

    /**
     * This is a part of Internal API
     */
    protected function call_action($controller, $action)
    {
        $controller = "App\\Controllers\\{$controller}";
        $controller = new $controller;

        if (!method_exists($controller, $action)) {
            $controller_name = get_class($controller);
            throw new \Exception(
                "{$controller_name} does not respond to the {$action} action."
            );
        }

        return $controller->$action();
    }
}
