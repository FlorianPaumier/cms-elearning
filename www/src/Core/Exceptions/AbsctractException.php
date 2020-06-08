<?php


namespace App\Core\Exceptions;

use App\Core\Renderer\RenderView;
use Exception;
use Throwable;

class AbsctractException extends Exception implements Throwable
{
    protected $code;

    public function __construct($message, $code, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}