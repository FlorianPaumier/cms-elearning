<?php


namespace App\Controllers;


use App\Core\Interfaces\BaseController;

class CoursController extends BaseController
{
    public function index(){
        return $this->renderer->render("cours");
    }
}