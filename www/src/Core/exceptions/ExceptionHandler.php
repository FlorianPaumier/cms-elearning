<?php


namespace App\Core\Exceptions;


use App\Core\Renderer\RenderView;
use App\Core\request\RedirectionHandler;
use App\Core\Request\Request;

/**
 * Class ExceptionHandler
 * @package App\Core\Exceptions
 */
class ExceptionHandler
{
    /**
     * Redirect to 405 page error
     *
     * @return false|string
     * @throws MethodNotAllowedException
     */
    public static function invalidMethodHandler($message = "Method not Allowed", $code = 405): void
    {
        //header("{$_SERVER["SERVER_PROTOCOL"]} 405 Method Not Allowed");
        throw new MethodNotAllowedException($message, $code);
    }

    /**
     * @throws ForbiddenException
     */
    public static function forbiddenHandler()
    {
        throw new ForbiddenException();
    }

    /**
     * @throws InvalidTokenException
     */
    public static function crsfInvalidHandler()
    {
        throw new InvalidTokenException();
    }

    /**
     * @throws ServerErrorException
     */
    public static function ServerErrorHandler(){
        throw new ServerErrorException();
    }

    /**
     * @throws ToManyRequestException
     */
    public static function ToManyRequestHandler(){
        throw new ToManyRequestException();
    }

    /**
     * @throws BadRequestException
     */
    public static function BadRequestHandler($message = "Bad Request", int $code = 400){
        throw new BadRequestException($message, $code);
    }

    /**
     * Redirect to 404 page error with message
     *
     * @param  $message
     * @return false|string
     * @throws NotFoundException
     */
    public static function NotFoundHandler($message = "Ce que vous cherchez n'est pas ici <a href='/'>Retour</a>",int $code = 404): void
    {
        //header("{$_SERVER["SERVER_PROTOCOL"]} 404 Not Found" . $message);
       throw new NotFoundException($message, $code);
    }
}