<?php


namespace App\Core\Exceptions;

use Throwable;

class NotFoundAbsctractException extends AbsctractException
{
    public function __construct(string $message,int $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}