<?php

namespace App\Core\Exceptions;

use App\Core\Interfaces\SubscriberInterface;
use App\Core\Render\RenderView;
use App\Core\Request\RedirectionHandler;

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
    public function serverErrorException(string $message = "Une erreur est survenue.", int $code = 500): void
    {
        $this->throwException(ServerErrorException::class, $message, $code);
    }

    /**
     * Redirect to 404 page error with message
     *
     * @param  $message
     * @return false|string
     */
    public function notFoundException(string $message = "Ce que vous cherchez n'est pas ici <a href='/'>Retour</a>", int $code = 404): void
    {
        $this->throwException(NotFoundAbsctractException::class, $message, $code);
    }

    public function notAuthorizedException(string $message = "Vous n'êtes pas autoriser à être ici", int $code = 401)
    {
        $this->throwException(ForbiddenException::class, $message, $code);
    }

    public function forbiddenException(string $message = "Vous devez vous connecter", int $code = 403)
    {
        $redirect = new RedirectionHandler();
        $redirect->redirectToRoute("app_home");
    }

    public function methodNotAllowedException(string $message = "Méthod non autoriser", int $code = 405)
    {
        $this->throwException(MethodNotAllowedAbsctractException::class, $message, $code);
    }

    /**
     * Throw exception or a pretty page
     */
    private function throwException(string $exception, string $message, int $code)
    {
        http_response_code($code);
        (new RenderView())->renderErrors("Errors/errors", new $exception($message, $code));
        exit;
    }
}
