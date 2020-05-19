<?php

namespace App\Core\Kernel;

use App\Core\Cache\ConfigHandler;
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
        try {
            ConfigHandler::get("router")->match();
        }catch (\Exception $e){
             (new RenderView())->renderErrors("errors/errors",$e);
            die;
        }


        /** @var RenderView $response */
        try {
            $response = ConfigHandler::get("router")->exec();
        }catch (\Exception $e){
            (new RenderView())->renderErrors("errors/errors",$e);
            die;
        }

        if (!$response) {
            try {
                ConfigHandler::get("eventEmmiter")->emit("error.500", "Le controller doit retourner une Strin ou FormBuilder , Null retourner");
            }catch (\Exception $e){
                 (new RenderView())->renderErrors("errors/errors",$e);
                die;
            }
        };

        try {
            $view = $response->compile();
        }catch (\Exception $e){
             (new RenderView())->renderErrors("errors/errors",$e);
            die;
        }

        echo $view;
    }

    /**
     * Set the working configuration
     */
    public function init()
    {
        (new ConfigHandler())->init();
    }
}
