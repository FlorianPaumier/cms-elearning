<?php


namespace App\Core\Exceptions;


use Throwable;

class BadRequestException extends ExceptionInterface
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}