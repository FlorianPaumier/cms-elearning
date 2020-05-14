<?php


namespace App\Controllers\Admin;


use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;

class ContactController extends BaseController
{

    public function index(Request $request)
    {
        return $this->render("admin/contact/index", [
            "contact" => $this->repository->from("contact")->findAll(),
        ]);
    }
}