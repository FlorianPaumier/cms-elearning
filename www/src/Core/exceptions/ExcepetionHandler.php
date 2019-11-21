<?php


namespace App\Core\Exception;


use App\Core\request\RedirectionHandler;
use App\Core\Request\Request;

class ExcepetionHandler
{
    //TODO: Remettre le template Engine
    /**
     * Redirect to 405 page error
     * @return false|string
     */
    public static function invalidMethodHandler(Request $request)
    {
        header("{$_SERVER["SERVER_PROTOCOL"]} 405 Method Not Allowed");
        if ($_SERVER["APP_ENV"] == "dev") {
            /*$renderer = new RenderView();
            $renderer->render("Errors/405", ["${$request->getServer()["SERVER_PROTOCOL"]} 405 Method Not Allowed"]);*/
        } else {
            //Send Mail
            $redirect = new RedirectionHandler();
            if (isset($_SERVER['HTTP_REFERER'])) {
                $redirect->redirectTo($_SERVER['HTTP_REFERER']);
            } else {
                $redirect->redirectToRoute("app_home");
            }
        }
    }

    public static function forbiddenHandler()
    {
        $redirect = new RedirectionHandler();
        $redirect->redirectToRoute("app_home");
    }

    public static function crsfInvalidHandler()
    {
        $redirect = new RedirectionHandler();
        $redirect->redirectToRoute("app_home");
    }

    /**
     * Redirect to 404 page error with message
     * @param $message
     * @return false|string
     */
    public static  function defaultRequestHandler($message = "Ce que vous cherchez n'est pas ici <a href='/'>Retour</a>"): void
    {
        header("{$_SERVER["SERVER_PROTOCOL"]} 404 Not Found" . $message);
        //(new RenderView())->render("Errors/404", ["message" => $message]);
        die();
    }
}