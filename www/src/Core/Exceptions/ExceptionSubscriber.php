<?php


namespace App\Core\Exceptions;


use App\Core\Interfaces\SubscriberInterface;
use App\Core\Render\RenderView;

class ExceptionSubscriber implements SubscriberInterface
{

    /** @var RenderView */
    private $view;

    public function getEvents(): array
    {
        return [
            "error.500" => [
                "method" => "serverErrorException",
            ],
        ];
    }


    /**
     * Redirect to 404 page error with message
     *
     * @param  $message
     * @return false|string
     */
    public function serverErrorException($message = "Ce que vous cherchez n'est pas ici <a href='/'>Retour</a>"): void
    {
        if($_SERVER["APP_ENV"]== "dev"){
            $this->view = (new RenderView())->render("Errors/404", ["message" => $message]);
        }else{
            header("{$_SERVER["SERVER_PROTOCOL"]} 404 Not Found" . $message);
        }
        die;
    }

    public function __destruct()
    {
        if($this->view)
            $this->view->compile();
    }
}