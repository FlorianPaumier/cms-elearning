<?php


namespace App\Controllers\Admin;


use App\Core\Database\Table;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\ContactForm;
use App\Form\ContactFormType;

class ContactController extends BaseController
{
    public function index(Request $request, Table $table)
    {
        return $this->renderer->render("admin/contact/index", [
            "forms" => $table->from("contact")->findAll()
        ]);
    }

    public function new(Request $request)
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if($request->getMethod() == "POST" && $form->isValid()){
            die;
        }

        return $this->renderer->render("admin/contact/new", [
            "form" => $form->createView(),
        ]);
    }

    public function edit(Request $request){

    }

    public function delete(Request $request)
    {

    }
}