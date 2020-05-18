<?php

namespace App\Core\Exceptions;

use Throwable;

class BDDException implements Throwable
{
    public function __construct($message, $code = 0)
    {
        parent::__construct($message, $code);
    }

    public function getMessage()
    {
        return $this->__toString();
    }

    public function getCode()
    {
        // TODO: Implement getCode() method.
    }

    public function getFile()
    {
        // TODO: Implement getFile() method.
    }

    public function getLine()
    {
        // TODO: Implement getLine() method.
    }

    public function getTrace()
    {
        // TODO: Implement getTrace() method.
    }

    public function getTraceAsString()
    {
        // TODO: Implement getTraceAsString() method.
    }

    public function getPrevious()
    {
        // TODO: Implement getPrevious() method.
    }

    public function __toString()
    {
        return $this->message;
    }
}