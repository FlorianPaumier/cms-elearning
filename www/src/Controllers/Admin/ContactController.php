<?php


namespace App\Controllers\Admin;


use App\Core\Contact\ContactForm;
use App\Core\Contact\ContactInput;
use App\Core\Database\EntityManager;
use App\Core\Form\FormTypeBuilderServices;
use App\Core\Formatter\Serializer;
use App\Core\Helpers\StringTransformer;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Repository\ContactInputRepository;
use App\Repository\ContactRepository;

class ContactController extends BaseController
{
    public function index(Request $request)
    {
        return $this->renderer->render("admin/contact/index", [
            "forms" => $this->entityManager->setEntity(ContactForm::class)->findAll()
        ]);
    }

    public function new(Request $request)
    {
        if($request->getMethod() == "POST" ){
            $formTypeBuilder = (new FormTypeBuilderServices($request->getRequest()->get("admin_contact")))->generate();

            $inputs = $formTypeBuilder->getInputs();
            $form = $formTypeBuilder->createFormTypeClass($request->getRequest()->all());

            $this->entityManager->from("contact_form")->persist($form);
            $this->entityManager->flush();

            /** @var ContactInput $input */
            foreach ($inputs as $input){
                $input->setContactForm($form);
                $this->entityManager->from("contact_input")->persist($input);
            }

            $this->entityManager->flush();
            $this->redirect->redirectToRoute("admin_contact_list");
        }

        return $this->render("admin/contact/new", []);
    }

    public function edit(Request $request,Serializer $serializer, ContactForm $contactForm, ContactInputRepository $contactInputRepository){
        $inputs = $contactInputRepository->orderBy("position", "ASC")->findBy(["contact_form" => $contactForm->getId()]);
        $json = $serializer->serialize($inputs, "json");

        if($request->getMethod() == "POST"){
            $formTypeBuilder = (new FormTypeBuilderServices($request->getRequest()->get("admin_contact")))->generate($contactForm);

            $inputs = $formTypeBuilder->getInputs();
            $form = $formTypeBuilder->createFormTypeClass($request->getRequest()->all(), $contactForm);

            $this->entityManager->from("contact_form")->persist($form);
            /** @var ContactInput $input */
            foreach ($inputs as $input){
                $this->entityManager->from("contact_input")->persist($input);
            }
            $this->entityManager->flush();
        }
        return $this->render("admin/contact/edit", ["inputs" => $json, "form" => $contactForm]);
    }

    public function delete(Request $request)
    {

    }
}