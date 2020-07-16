<?php


namespace App\Controllers\Admin;


use App\Core\Cache\ConfigHandler;
use App\Core\Interfaces\BaseController;
use App\Core\Mailer\MailerHandler;
use App\Core\Mailer\MailerMessage;
use App\Core\Request\Request;
use App\Entity\Article;
use App\Entity\Newsletter;
use App\Entity\NewsletterEmail;
use App\Form\NewsletterForm;
use App\Repository\NewsletterEmailRepository;
use App\Repository\NewsletterRepository;

class NewsletterController extends BaseController
{
    public function index(Request $request)
    {
        return $this->renderer->render("admin/newsletter/index",[
            "method" => $request->getMethod(),
            "title" => "Index"
        ]);
    }

    public function list(NewsletterRepository $repository)
    {
        $newsletters = $repository->paginate(5);

        return $this->renderer->render("admin/newsletter/list",[
            "newsletters" => $newsletters,
            "title" => "Liste des newsletters"
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function new(Request $request)
    {
        $newsletter = new Newsletter();

        $form = $this->createForm(NewsletterForm::class, $newsletter);
        $form->handleRequest($request);

        if($form->isValid()) {
            $em = ConfigHandler::get("entityManager");
            $em->persist($newsletter);
            $em->flush();
            $this->redirect->redirectToRoute("admin_newsletter_list");
        }

        return $this->renderer->render("admin/newsletter/new",[
            "title" => "Création de newsletter",
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
            $this->redirect->redirectToRoute("admin_newsletter_list");
        }

        return $this->renderer->render("admin/newsletter/edit", [
            "form" => $form->createView(),
            "title" => "Modification de la newsletter"
        ]);
    }

    public function delete(Request $request, Article $article)
    {
        $this->redirect->redirectToRoute("admin_newsletter_list");
    }

    public function send(Newsletter $newsletter, MailerHandler $mailer, NewsletterEmailRepository $emailRepository)
    {
        $emails = $emailRepository->findAll();
        dump($newsletter->getId());

        foreach($emails as $email) {
            $message = new MailerMessage();

            $message->setDest($email->getEmail());
            $message->setSubjet($newsletter->getTitle());
            $message->setBody($newsletter->getContent());
            $mailer->send($message);
        }
    }
}