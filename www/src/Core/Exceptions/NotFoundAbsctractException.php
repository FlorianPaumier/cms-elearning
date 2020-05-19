<?php


namespace App\Core\Exceptions;

use Throwable;

class NotFoundAbsctractException extends AbsctractException
{
    public function __construct($message, $code, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}