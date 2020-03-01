<?php

namespace App\Controllers\Dashboard;

use App\Core\Interfaces\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        return $this->renderer->render("admin/dashboard/dashboard");
    }

    public function sidebar()
    {
        return $this->renderer->render("partials/sidebar");
    }

    public function design()
    {
        return $this->renderer->render(ROOT_DIR . "/public/views/admin/dashboard/dashboard_design");
    }
}