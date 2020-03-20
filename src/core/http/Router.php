<?php

namespace EduCat\Core\Http;

use EduCat\Core\App;
use EduCat\Core\Templating\Renderer;
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
        // I CAN'T EVEN how inefficient this is
        foreach ($this->routes[$request_type] as $app_name => $definition) {
            foreach ($definition as $pattern => $controller) {
                $params = [];
                if (preg_match($pattern, $uri, $params)) {
                    $route = explode('@', $controller);
                    $named_params = array_filter($params, "is_string", ARRAY_FILTER_USE_KEY);

                    return $this->call_action(
                        $app_name,
                        $route[0], // controller
                        $route[1], // action
                        array_values($named_params)
                    );
                }
            }
        }

        Router::display_404($uri);
    }

    /**
     * Initialize router by reading the routes file
     * 
     * @param string $routes_file Path to the routes file
     */
    public static function load()
    {
        $router = new static;
        foreach (App::get('apps') as $app_name) {
            $routes_file = $_SERVER['DOCUMENT_ROOT'] . '/apps/' . $app_name . '/routes.php';
            require($routes_file);
        }

        return $router;
    }

    /**
     * Register a GET request handler
     * 
     * Example:
     * $router->get('users', '/^users\/(?P<id>[-\w]+)$/iA', 'UsersController@get_user');
     * Will match /users/1 and pass '1' as the first param to UserController's get_user action 
     * with 'users' as the application name.
     * 
     * Using multiple parameter names is supported as long as they don't overlap.
     * Numeric parameter names are not supported and will break the app in unimaginable ways.
     * 
     * @param string $app Application's name (used to resolve its directory)
     * @param string $pattern Pattern defining route
     * @param string $controller Name of Controller and it's handling action
     */
    public function get($app, $pattern, $controller)
    {
        $this->routes['GET'][$app][$pattern] = $controller;
    }

    /**
     * Register a POST request handler
     * 
     * Example:
     * $router->post('users', '/^users\/(?P<id>[-\w]+)$/iA', 'UsersController@get_user');
     * Will match /users/1 and pass '1' as the first param to UserController's get_user action 
     * with 'users' as the application name.
     * 
     * Using multiple parameter names is supported as long as they don't overlap.
     * Numeric parameter names are not supported and will break the app in unimaginable ways.
     *   
     * @param string $app Application's name (used to resolve its directory)
     * @param string $pattern Pattern defining route
     * @param string $controller Name of Controller and it's handling action
     */
    public function post($app, $pattern, $controller)
    {
        $this->routes['POST'][$app][$pattern] = $controller;
    }

    /**
     * Render a 404 Not Found page
     * 
     * @param string $uri URI That wasn't found
     */
    public static function display_404($uri)
    {
        return Renderer::static_render('404', compact('uri'));
    }

    /**
     * This is a part of Internal API
     */
    protected function call_action($app_name, $controller, $action, $params)
    {
        $ns_name = ucfirst($app_name);
        $controller = "EduCat\\Controllers\\$ns_name\\{$controller}";
        $controller = new $controller($app_name);

        if (!method_exists($controller, $action)) {
            $controller_name = get_class($controller);
            throw new \Exception(
                "{$controller_name} does not respond to the {$action} action."
            );
        }

        return $controller->$action(...$params);
    }
}
