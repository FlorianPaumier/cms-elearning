<?php


namespace App\Controllers\Admin;


use App\Core\Database\Table;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;

class ContactController extends BaseController
{
    public function index(Request $request, Table $table)
    {
        //$table->from("contact")->findAll();
        $this->renderer->render("admin/contact/index", []);
    }

    public function new(Request $request)
    {

    }

    public function edit(Request $request){

    }

    public function delete(Request $request)
    {

    }
}