<?php

namespace App\Controllers\Admin;

use App\Core\Helpers\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        return $this->renderer->render(ROOT_PATH . "/public/views/admin/home");
    }
}