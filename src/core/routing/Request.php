<?php

namespace App\Core\Routing;


class Request
{
    /**
     * Get the URI part of the request
     * 
     * @return string
     */
    public function uri()
    {
        return trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    }

    /**
     * Get the request method
     * 
     * @return string
     */
    public function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Get the request POST data
     * 
     * @return mixed
     */
    public function data()
    {
        return $_POST;
    }
}
