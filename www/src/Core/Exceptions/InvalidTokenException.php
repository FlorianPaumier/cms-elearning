<?php


namespace App\Core\Exceptions;


use Throwable;

class InvalidTokenException extends AbsctractException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}