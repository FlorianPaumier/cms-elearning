<?php


namespace App\Controllers\Admin;


use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;

class EventController extends BaseController
{

    public function index()
    {
        $this->renderer->render("admin/events/list");
    }

    public function new()
    {
        $this->renderer->render("admin/events/form");
    }

    public function edit($id)
    {
        $this->renderer->render("admin/events/form", ["id" => $id]);
    }
}