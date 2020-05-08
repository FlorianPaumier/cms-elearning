<?php


namespace App\Controllers;


use App\Core\Interfaces\BaseController;
use App\Core\Mailer\MailerHandler;
use App\Core\Request\Request;
use App\Entity\Configuration;
use App\Entity\ContactForm;
use App\Entity\ContactMeta;
use App\Entity\ContactObject;

class ContactController extends BaseController
{

    public function index(Request $request, MailerHandler $handler)
    {
        /** @var ContactForm $contactForm */
        $contactForm = $this->repository->setEntity(ContactForm::class)->from("contact_form")->findBy(["enabled" => true])[0];

        $form = $this->createForm($contactForm->getPath());
        $form->handleRequest($request);

        if ($request->getMethod() == "POST" && $form->isValid()) {
            $data = $request->getRequest()->all();

            $contact = new ContactObject();
            $this->repository->persist($contact);
            $this->repository->flush();

            foreach ($data as $key => $value) {
                $field = new ContactMeta();
                $name = explode("_",$key);
                $field->setInput(array_pop($name));
                $field->setValue($value);

                $field->setContact($contact);
                $this->repository->persist($field);
            }

            $this->repository->flush();
            $dest = $this->repository->setEntity(Configuration::class)->from("configuration")->fetchOrFail()[0];
            $handler->setDest($dest->getContact());
            $handler->setBody("New Contact");
            $handler->send();
            $this->redirect->redirectToRoute("app_contact");
        }

        return $this->render("contact", [
            "form" => $form->createView(),
            "name" => $contactForm->getName()
        ]);
    }
}