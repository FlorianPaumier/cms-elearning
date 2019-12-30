<?php


namespace App\Core\Exceptions;

use App\Core\Renderer\RenderView;
use Exception;
use Throwable;

class ExceptionInterface extends Exception implements Throwable
{
    protected $code;

    public function __construct($message, $code, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function render()
    {
        http_response_code($this->code);

        (new RenderView())->render("Errors/errors", [
            "message" => $this->getMessage(),
            "line" => $this->getLine(),
            "trace" => $this->getTrace(),
            "code" => $this->code,
        ]);
        exit();
    }
}