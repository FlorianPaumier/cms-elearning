<?php
namespace App\Controllers;

use App\Core\Interfaces\BaseController;

class DefaultController extends BaseController
{
    public function index()
    {
        return $this->renderer->render(ROOT_DIR."/public/views/home");
    }
}