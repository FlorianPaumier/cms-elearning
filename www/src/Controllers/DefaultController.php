<?php
namespace App\Controllers;

use App\Core\Helpers\BaseController;

class DefaultController extends BaseController
{
    public function index()
    {
        $this->renderer->render("homee");
    }
    public function doc()
    {
        $this->renderer->render("doc");
    }
}