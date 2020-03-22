<?php
namespace App\Controllers;

use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;

class DefaultController extends BaseController
{
    public function index(Request $request)
    {
        return $this->renderer->render("home", [
            "method" => $request->getMethod(),
        ]);
    }
    public function doc()
    {
        $this->renderer->render("doc");
    }
}
