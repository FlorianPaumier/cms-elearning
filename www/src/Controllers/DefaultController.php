<?php
namespace App\Controllers;

use App\Core\Interfaces\BaseController;
use App\Entity\User;

class DefaultController extends BaseController
{
    public function index()
    {
        $user = new User(1);
        $this->renderer->render("home");
    }
}