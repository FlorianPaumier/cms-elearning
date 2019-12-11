<?php
namespace App\Controllers;

use App\Core\Interfaces\BaseController;
use App\Core\Mailer\SendMailHandler;

class DefaultController extends BaseController
{
    public function index()
    {
        $mailer = new SendMailHandler();
        $mailer->contact(["devweb.paumier@gmail.com"]);
        $this->renderer->render("home");
    }
}