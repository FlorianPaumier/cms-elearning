<?php

namespace App\Core\Exceptions;

use App\Core\Interfaces\SubscriberInterface;
use App\Core\Render\RenderView;

class ExceptionSubscriber implements SubscriberInterface
{

    /** @var RenderView */
    private $view;

    public function getEvents(): array
    {
        return [
            "error.500" => [
                "method" => "serverErrorException",
            ],
            "error.404" => [
                "method" => "notFoundException",
            ],
            "error.401" => [
                "method" => "notAuthorizedException",
            ],
            "error.403" => [
                "method" => "forbiddenException",
            ],
            "error.405" => [
                "method" => "methodNotAllowedException",
            ],
        ];
    }

    /**
     * Redirect to 500 page error with message
     *
     * @param  $message
     * @return false|string
     */
    public function serverErrorException($message = "Une erreur est survenue."): void
    {
        if ($_SERVER["APP_ENV"] == "dev") {
            throw new NotFoundAbsctractException($message, 500);
        } else {
            header("{$_SERVER["SERVER_PROTOCOL"]} 500 server error" . $message);
        }
        die;
    }

    /**
     * Redirect to 404 page error with message
     *
     * @param  $message
     * @return false|string
     */
    public function notFoundException($message = "Ce que vous cherchez n'est pas ici <a href='/'>Retour</a>"): void
    {
        if ($_SERVER["APP_ENV"] == "dev") {
            throw new NotFoundAbsctractException($message, 404);
        } else {
            header("{$_SERVER["SERVER_PROTOCOL"]} 404 not found" . $message);
        }
    }

    public function forbiddenException(string $message = "Vous devez vous connecter"){
        throw new ForbiddenException($message, 403);
    }

    public function notAuthorizedException(string $message = "Vous n'êtes pas autoriser à être ici"){
        throw new ForbiddenException($message, 401);
    }

    public function methodNotAllowedException(string $message = "Méthod non autoriser"){
        throw new ForbiddenException($message, 405);
    }

}
