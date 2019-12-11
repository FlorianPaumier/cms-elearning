<?php
namespace App\Controllers;

use App\Core\Interfaces\BaseController;
use App\Core\Mailer\SendMailHandler;

class DefaultController extends BaseController
{
    public function index()
    {
        $this->renderer->render("home");
    }
}