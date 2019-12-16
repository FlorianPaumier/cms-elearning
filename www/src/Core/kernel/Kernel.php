<?php

namespace App\Core\kernel;


use App\Core\Exceptions\ExceptionHandler;
use App\Core\Exceptions\NotFoundException;

class Kernel
{
    /*
     * The container application
     */
    protected static $registry = [];

    public function __construct(string $env, bool $debug = false)
    {
        $_SERVER["APP_ENV"] = $env;
        $_SERVER["APP_DEBUG"] = $debug;


        include_once dirname(__DIR__)."/helpers/VarDumper.php";
        include_once dirname(__DIR__)."/helpers/basicFunction.php";
    }

    /**
     * Get instance of the key in the container
     *
     * @param  string $key
     * @return mixed
     * @throws \Exception
     */
    public static function get(string $key)
    {
        if (!key_exists($key, self::$registry)) {
            throw new NotFoundException("Key '${key}' don't exist", 404);
        }

        return self::$registry[$key];
    }

    /**
     * Entry of the application
     *
     * @return show the result of the application
     */
    public static function resolve()
    {
        self::$registry["router"]->isMatch();
    }

    /**
     * Set the value in the container
     *
     * @param string $key
     * @param $value
     */
    public static function bind(string $key, $value)
    {
        self::$registry[$key] = $value;
    }

    /**
     * Set the working configuration
     */
    public function init()
    {
        define("PATH_STYLE", ROOT_DIR. "/public/styles");
        define("PATH_SCRIPT", ROOT_DIR . "/public/scripts");
        define("PATH_LIBRARY", ROOT_DIR . "/node_modules");

        (new ConfigHandler())->init();
    }
}