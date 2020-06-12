<?php


namespace App\Core\Exceptions;


use Throwable;

class MethodNotAllowedAbsctractException extends AbsctractException
{
    public function __construct($message = "", $code = 405, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}