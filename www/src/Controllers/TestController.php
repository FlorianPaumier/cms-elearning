<?php


namespace App\Controllers;


use App\Core\Helpers\BaseController;

class TestController extends BaseController
{

    public function success()
    {
        $this->renderer->render("home");
    }

    public function viewNotFound()
    {
        $this->renderer->render("homee");
    }

    public function paramNotFound()
    {
        $this->renderer->render("home");
    }

    public function forbidden()
    {
        $this->renderer->render("home");
    }

    public function invalidMethod()
    {
        $this->renderer->render("home");
    }
}