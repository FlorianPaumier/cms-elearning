<?php

namespace App\Controllers\Admin;

use App\Core\Interfaces\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        $_SESSION['id'] = 1;
//        dump($_SESSION);
        return $this->renderer->render(ROOT_PATH . "/public/views/admin/home");
    }
}