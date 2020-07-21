<?php


namespace App\Controllers\Admin;


use App\Core\Cache\ConfigHandler;
use App\Core\Interfaces\BaseController;
use App\Core\Mailer\MailerHandler;
use App\Core\Mailer\MailerMessage;
use App\Core\Request\Request;
use App\Entity\Newsletter;
use App\Entity\NewsletterEmail;
use App\Form\NewsletterEmailForm;
use App\Form\NewsletterForm;
use App\Repository\NewsletterEmailRepository;
use App\Repository\NewsletterRepository;

class NewsletterEmailController extends BaseController
{
    public function index(Request $request)
    {
        return $this->renderer->render("admin/newsletterEmail/index",[
            "method" => $request->getMethod(),
            "title" => "Index"
        ]);
    }

    public function list(NewsletterEmailRepository $repository)
    {
        $emails = $repository->paginate(5);

        return $this->renderer->render("admin/newsletterEmail/list",[
            "emails" => $emails,
            "title" => "Liste des emails newsletter"
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function new(Request $request)
    {
        $newsletterEmail = new NewsletterEmail();

        $form = $this->createForm(NewsletterEmailForm::class, $newsletterEmail);
        $form->handleRequest($request);

        if($form->isValid()) {
            $em = ConfigHandler::get("entityManager");
            $em->persist($newsletterEmail);
            $em->flush();
            $this->redirect->redirectToRoute("admin_newsletter_email_list");
        }

        return $this->renderer->render("admin/newsletterEmail/new",[
            "title" => "Création d'email newsletter",
            "form" => $form->createView(),
            "errors"=> $form->getErrorFeedback()
        ]);
    }

    public function edit(Request $request, NewsletterRepository $repository, Newsletter $newsletters)
    {
        $newsletter = $repository->findBy(['id' => $newsletters->getId()]);

        $form = $this->createForm(NewsletterForm::class, $newsletter);
        $form->handleRequest($request);

        if ($request->getMethod() == "POST" && $form->isValid()) {
            $em = ConfigHandler::get("entityManager");
            $em->persist($newsletter);
            $em->flush();
            $this->redirect->redirectToRoute("admin_newsletter_email_list");
        }

        return $this->renderer->render("admin/newsletterEmail/edit", [
            "form" => $form->createView(),
            "title" => "Modification d'email newsletter"
        ]);
    }

    public function delete(NewsletterEmail $email)
    {
        $this->entityManager->delete($email);
        $this->redirect->redirectToRoute("admin_newsletter_email_list");
    }
}