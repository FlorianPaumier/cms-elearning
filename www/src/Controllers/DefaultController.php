<?php

namespace App\Controllers;

use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;

class DefaultController extends BaseController
{
    public function index(Request $request)
    {
        dump($this->session->get("app.user"));
        return $this->renderer->render("home", [
            "method" => $request->getMethod(),
        ]);
    }

    public function doc()
    {
        return $this->renderer->render("doc");
    }
}
