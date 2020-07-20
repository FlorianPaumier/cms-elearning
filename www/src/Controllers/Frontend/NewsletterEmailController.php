<?php


namespace App\Controllers\Frontend;


use App\Core\Cache\ConfigHandler;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\NewsletterEmail;
use App\Form\NewsletterEmailForm;
use Exception;

class NewsletterEmailController extends BaseController
{
    /**
     * @param Request $request
     * @throws Exception
     */
    public function new(Request $request)
    {
        $newsletter = new NewsletterEmail();

        $form = $this->createForm(NewsletterEmailForm::class, $newsletter);
        $form->handleRequest($request);

        if($request->getMethod() == "POST" && $form->isValid()) {
            $em = ConfigHandler::get("entityManager");
            $em->persist($newsletter);
            $em->flush();
            $this->redirect->redirectToRoute("newsletter_list");
        } else {
            $this->redirect->redirectToRoute("home");
        }
    }
}