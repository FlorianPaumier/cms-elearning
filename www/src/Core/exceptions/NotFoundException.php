<?php


namespace App\Core\Exceptions;

use Throwable;

class NotFoundException extends ExceptionInterface
{
    public function __construct($message, $code, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->render();
    }
}