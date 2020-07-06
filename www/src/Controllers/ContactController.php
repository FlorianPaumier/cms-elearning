<?php


namespace App\Controllers;


use App\Core\Contact\ContactForm;
use App\Core\Contact\ContactInput;
use App\Core\Contact\ContactMeta;
use App\Core\Contact\EvaluationObject;
use App\Core\Interfaces\BaseController;
use App\Core\Mailer\MailerHandler;
use App\Core\Mailer\MailerMessage;
use App\Core\Request\Request;
use App\Entity\SiteConfiguration;
use App\Repository\ContactInputRepository;
use App\Repository\ContactFormRepository;
use App\Repository\SiteConfigurationRepository;
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

            $contact = new EvaluationObject();
            $contact->setContactForm($contactForm);
            $this->entityManager->persist($contact);

            $fields = [];

            foreach ($data as $key => $value) {
                $field = new ContactMeta();
                $name = explode("_",$key);
                $inputRepo = new ContactInputRepository();

                /** @var ContactInput $input */
                $input = $inputRepo->findOneBy([
                    "form_key" => end($name),
                    "contact_form_id" => $contactForm->getId()
                ]);

                if($input->getType() == "submit"){
                    continue;
                }
                
                $field->setInput($input);
                $field->setValue($value);

               $fields[end($name)] = $value;

                $field->setContact($contact);
                $this->entityManager->persist($field);
            }

            $this->entityManager->flush();
            $configRepo = new SiteConfigurationRepository();
            $dest = $configRepo->findOneBy(["key" => "email"]);

            $message = new MailerMessage();
            $message->setDest($dest->getValue());
            $message->setSubjet($fields["subject"]);
            $message->setBody($fields["message"]);
            $mailer->send($message);

            $this->redirect->redirectToRoute("frontend_form_contact");
        }

        return $this->render("contact", [
            "form" => $form->createView(),
            "name" => $contactForm->getName()
        ]);
    }
}