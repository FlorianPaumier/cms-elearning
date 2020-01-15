<?php
namespace App\Controllers;

use App\Core\Interfaces\BaseController;
use App\Core\renderer\Nodes\CaptchaNode;

class DefaultController extends BaseController
{
    public function index()
    {
        $this->renderer->render("home");
    }

    public function doc()
    {
        $this->renderer->render("doc");
    }
}