<?php


namespace App\Core\Exceptions;


use Throwable;

class MethodNotAllowedException extends ExceptionInterface
{
    public function __construct($message = "", $code = 405, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->render();
    }
}