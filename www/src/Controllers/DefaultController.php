<?php

namespace App\Controllers;

use App\Core\Cache\ConfigHandler;
use App\Core\Interfaces\BaseController;
use App\Core\Render\RenderView;
use App\Core\Request\Request;
use App\Entity\NewsletterEmail;
use App\Form\ChapterBlockForm;
use App\Form\NewsletterEmailForm;
use App\Repository\UserRepository;
use Exception;

class DefaultController extends BaseController
{
    /**
     * @param Request $request
     * @return RenderView|string|string[]|null
     * @throws Exception
     */
    public function index(Request $request)
    {
        $newsletterEmail = new NewsletterEmail();

        $form = $this->createForm(NewsletterEmailForm::class, $newsletterEmail);
        $form->handleRequest($request);

        if($form->isValid()) {
            $em = ConfigHandler::get("entityManager");
            $em->persist($newsletterEmail);
            $em->flush();
            $this->redirect->redirectTo("/");
        }

        return $this->renderer->render("home", [
            "errors"=> $form->getErrorFeedback(),
            "form" => $form->createView(),
            "method" => $request->getMethod()
        ]);
    }

    /**
     * @return RenderView|string|string[]|null
     * @throws Exception
     */
    public function doc()
    {
        return $this->renderer->render("doc");
    }
}
