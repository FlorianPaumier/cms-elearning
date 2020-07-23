<?php


namespace App\Controllers\Admin;


use App\Core\Cache\ConfigHandler;
use App\Core\Interfaces\BaseController;
use App\Core\Mailer\MailerHandler;
use App\Core\Mailer\MailerMessage;
use App\Core\Render\RenderView;
use App\Core\Request\Request;
use App\Entity\Newsletter;
use App\Entity\NewsletterEmail;
use App\Form\NewsletterForm;
use App\Repository\NewsletterEmailRepository;
use App\Repository\NewsletterRepository;
use Exception;

class NewsletterController extends BaseController
{
    /**
     * display list of email template
     *
     * @param NewsletterRepository $repository
     * @return RenderView|string|string[]|null
     * @throws Exception
     */
    public function index(NewsletterRepository $repository)
    {
        $newsletters = $repository->paginate(5);

        return $this->renderer->render("admin/newsletter/list",[
            "newsletters" => $newsletters,
            "title" => "Liste des newsletters"
        ]);
    }

    /**
     * display list of email template
     *
     * @param NewsletterRepository $repository
     * @return RenderView|string|string[]|null
     * @throws Exception
     */
    public function list(NewsletterRepository $repository)
    {
        $newsletters = $repository->paginate(5);

        return $this->renderer->render("admin/newsletter/list",[
            "newsletters" => $newsletters,
            "title" => "Liste des newsletters"
        ]);
    }

    /**
     * display a form to create a new item and insert the data if exist
     *
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
            $newsletter->setUser($this->getUser());
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

    /**
     * display a form to edit an item and update the data if exist
     *
     * @param Request $request
     * @param NewsletterRepository $repository
     * @param Newsletter $newsletters
     * @return RenderView|string|string[]|null
     * @throws \App\Core\Exception\NoRecordException
     */
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

    /**
     * delete an item
     *
     * @param Newsletter $newsletter
     * @throws Exception
     */
    public function delete(Newsletter $newsletter)
    {
        $this->entityManager->delete($newsletter);
        $this->redirect->redirectToRoute("admin_newsletter_list");
    }

    /**
     * function to send an email with the selected email template to all subscribers
     *
     * @param Newsletter $newsletter
     * @param MailerHandler $mailer
     * @param NewsletterEmailRepository $emailRepository
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function send(Newsletter $newsletter, MailerHandler $mailer, NewsletterEmailRepository $emailRepository)
    {
        $emails = $emailRepository->findAll();

        foreach($emails as $email) {
            $message = (new MailerMessage())
                ->setDest($email->getEmail())
                ->setSubjet($newsletter->getTitle())
                ->setBody($newsletter->getContent());
            $mailer->send($message);
        }

        $this->redirect->redirectToRoute("admin_newsletter_list");
    }
}