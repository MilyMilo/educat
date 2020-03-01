<?php

namespace App\Core;


class App
{
    protected static $container = [];

    /**
     * Attach some value to the App singleton
     * 
     * @param string $key Key to identify the value
     * @param mixed $value The value to attach
     */
    public static function bind($key, $value)
    {
        static::$container[$key] = $value;
    }

    /**
     * Retrieve value from the App singleton by key
     * 
     * @param string $key Key to identify the value
     * @return mixed $value The value attached
     */
    public static function get($key)
    {
        if (array_key_exists($key, static::$container)) {
            return static::$container[$key];
        }
        throw new \Exception("Couldn't load settings");
    }
}
