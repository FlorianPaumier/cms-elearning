<?php


namespace App\Controllers\Dashboard;


use App\Core\Helpers\BaseController;

class DashboardController extends BaseController
{

    public function index()
    {
        $this->renderer->render("home");
    }
}