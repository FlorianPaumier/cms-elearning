<?php


namespace App\Controllers;


use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\ContactForm;

class ContactController extends BaseController
{

    public function index(Request $request)
    {
        /** @var ContactForm $contactForm */
        $contactForm = $this->repository->setEntity(ContactForm::class)->from("contact_form")->findBy(["enabled" => true])[0];

        $contact = new \stdClass();
        $form = $this->createForm($contactForm->getPath(), $contact);
        $form->handleRequest($request);

        if($request->getMethod() == "POST" && $form->isValid()){
            die;
        }

        return $this->render("contact", [
            "form" => $form->createView(),
            "name" => $contactForm->getName()
        ]);
    }
}