<?php


namespace App\Controllers;


use App\Core\Contact\ContactForm;
use App\Core\Contact\ContactInput;
use App\Core\Contact\ContactMeta;
use App\Core\Contact\ContactObject;
use App\Core\Interfaces\BaseController;
use App\Core\Mailer\MailerHandler;
use App\Core\Mailer\MailerMessage;
use App\Core\Request\Request;
use App\Entity\SiteConfiguration;
use App\Repository\ContactInputRepository;
use App\Repository\ContactFormRepository;
use PHPUnit\Util\Configuration;

class ContactController extends BaseController
{

    public function index(Request $request, MailerHandler $mailer, ContactFormRepository $repository)
    {
        /** @var ContactForm $contactForm */
        $contactForm = $repository->findOneBy(["enabled" => true]);

        if(is_null($contactForm)) $this->redirect->redirectToRoute("app_home");

        $form = $this->createForm($contactForm->getPath());
        $form->handleRequest($request);

        if ($request->getMethod() == "POST" && $form->isValid()) {
            $data = $request->getRequest()->all();

            $contact = new ContactObject();
            $contact->setContactForm($contactForm);
            $this->entityManager->persist($contact);

            foreach ($data as $key => $value) {
                $field = new ContactMeta();
                $name = explode("_",$key);
                $inputRepo = new ContactInputRepository();
                $input = $inputRepo->findOneBy([
                    "form_key" => end($name),
                    "contact_form" => $contactForm->getId()
                ]);

                $field->setInput($input);
                $field->setValue($value);

                $field->setContact($contact);
                $this->entityManager->persist($field);
            }

            $this->entityManager->flush();
            $dest = $this->entityManager->clear()->setEntity(SiteConfiguration::class)->from("site_configuration")->find(16);

            $message = new MailerMessage();
            $message->setDest($dest->getContact());
            $message->setBody("New Contact");
            $mailer->send($message);

            $this->redirect->redirectToRoute("frontend_form_contact");
        }

        return $this->render("contact", [
            "form" => $form->createView(),
            "name" => $contactForm->getName()
        ]);
    }
}