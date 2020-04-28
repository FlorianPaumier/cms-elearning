<?php

namespace App\Core\Kernel;


use App\Core\Cache\CacheHandler;
use App\Core\Cache\ConfigHandler;
use App\Core\Events\EventEmmiter;
use App\Core\Render\RenderView;
use PHPUnit\Util\Exception;

/**
 * Point d'entré et de sortie de notre appplication
 * Class Kernel
 * @package App\Core\Kernel
 */
class Kernel
{

    public function __construct(string $env, bool $debug = false)
    {
        $_SERVER["APP_ENV"] = $env;
        $_SERVER["APP_DEBUG"] = $debug;

        /** Récupération des éléments de base */
        include_once dirname(__DIR__) . "/Helpers/VarDumper.php";
        include_once dirname(__DIR__) . "/Helpers/basicFunction.php";
    }

    /**
     * Lancement de l'application
     * 1 - Gestion de la route
     * 2 - Gestion de la vue
     */
    public function resolve()
    {
        /**
         * Test if the current url match with the routing file
         */
        $matched = ConfigHandler::get("router")->match();

        if ($matched === false) {
            ConfigHandler::get("eventEmmiter")->emit("error.404", "Aucune route n'a été trouvé pour l'url");
        }

        /** @var RenderView $response */
        $response = ConfigHandler::get("router")->exec();

        if (!$response){
            ConfigHandler::get("eventEmmiter")->emit("error.500", "Le controller doit retourner une Strin ou FormBuilder , Null retourner");
        };

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