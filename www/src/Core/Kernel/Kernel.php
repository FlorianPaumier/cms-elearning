<?php

namespace App\Core\Kernel;


use App\Core\Cache\CacheHandler;
use App\Core\Cache\ConfigHandler;
use App\Core\Render\RenderView;
use Exception;

class Kernel
{

    public function __construct(string $env, bool $debug = false)
    {
        $_SERVER["APP_ENV"] = $env;
        $_SERVER["APP_DEBUG"] = $debug;


        include_once dirname(__DIR__) . "/Helpers/VarDumper.php";
        include_once dirname(__DIR__) . "/Helpers/basicFunction.php";
    }


    public function resolve()
    {
        $matched = ConfigHandler::get("router")->match();

        if ($matched === false) throw new Exception("Route not Found", 404);

        /** @var RenderView $response */
        $response = ConfigHandler::get("router")->exec();

        if (!$response) throw new \Exception("La méthode doit retourne une valeur", 500);

        $response->compile();
    }


    /**
     * Set the working configuration
     */
    public function init()
    {
        (new ConfigHandler())->init();
    }
}