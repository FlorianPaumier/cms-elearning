<?php


namespace App\Controllers\Admin;


use App\Core\Database\Table;
use App\Core\Form\FormTypeBuilderServices;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\ContactForm;
use App\Form\ContactFormType;

class ContactController extends BaseController
{
    public function index(Request $request)
    {
        return $this->renderer->render("admin/contact/index", [
            "forms" => $this->repository->from("contact")->findAll()
        ]);
    }

    public function new(Request $request)
    {

        if($request->getMethod() == "POST" ){
            $formTypeBuilder = new FormTypeBuilderServices($request->getRequest()->get("admin_contact"));

            $class = $formTypeBuilder
                ->generate()
                ->createFormTypeClass($request->getRequest()->get("admin_contact_class"));
            ;

            $form = $this->createForm($class, $lesson);
            $form->handleRequest($request);

            return $this->renderer->render("admin/lessons/new", [
                "form" => $form->createView(),
                'title' => "Création d'un Cour"
            ]);
        }

        return $this->render("admin/contact/new", []);
    }

    public function edit(Request $request){

    }

    public function delete(Request $request)
    {

    }
}