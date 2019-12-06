<?php

class DashboardController extends BaseController{

    public function index(){
        $this->renderer->render("dashboard/dashboard");
    }
}