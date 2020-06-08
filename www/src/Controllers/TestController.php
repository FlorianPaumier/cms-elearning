<?php


namespace App\Controllers;


use App\Core\Interfaces\BaseController;

class TestController extends BaseController
{
    public function simpleRouting()
    {
        return "Ok";
    }

    public function complexTeouting($id)
    {
        return $id;
    }

    public function forbidden($id)
    {
        return $id;
    }

    public function errorView()
    {
        $this->renderer->render("homee");
    }
}