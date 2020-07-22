<?php

namespace App\Controllers\Admin;

use App\Core\Cache\ConfigHandler;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\Faq;
use App\Form\FaqForm;
use App\Repository\FaqRepository;

class FaqController extends BaseController
{
    /**
     * Home Faq
     * @param FaqRepository $faqRepository
     * @return \App\Core\Render\RenderView|string|string[]|null
     * @throws \Exception
     */
    public function index(FaqRepository $faqRepository)
    {
        // Get the questions from the FAQ
        $questions = $faqRepository->findAll();
        // If there is at least one question in the FAQ
        $questions = !empty($questions) ? $questions : [];

        // Return the home view with FAQ questions
        return $this->renderer->render("admin/faq/index", [
            'questions' => $questions,
            'title' => 'Liste des Question / Réponse'
        ]);
    }

    /**
     * Add a new question in the FAQ
     * @param Request $request
     * @return \App\Core\Render\RenderView|string|string[]|null
     * @throws \Exception
     */
    public function new(Request $request)
    {
        // Initialization of a new question
        $faq = new Faq();

        // Calling the addition form with the object FAQ
        $form = $this->createForm(FaqForm::class, $faq);
        // Retrieves the parameters of the request
        $form->handleRequest($request);

        // If the form is in POST and it is valid
        if ($request->getMethod() == "POST" && $form->isValid()) {
            // Saving the question
            /** @var Table $em */
            $em = ConfigHandler::get("entityManager");
            $em->persist($faq);
            $em->flush();
            // Redirection to the home page
            $this->redirect->redirectToRoute("admin_faq_list");
        }

        // Otherwise if there is no receipt of request, display of the add view
        return $this->renderer->render("admin/faq/new", [
            'form' => $form->createView(),
            'title' => "Création d'une Question/Réponse"
        ]);
    }

    /**
     * Edit a question
     * @param Request $request
     * @param Faq $faq
     * @return \App\Core\Render\RenderView|string|string[]|null
     * @throws \Exception
     */
    public function edit(Request $request, Faq $faq)
    {
        // Calling the editing form with the object FAQ
        $form = $this->createForm(FaqForm::class, $faq);
        // Retrieves the parameters of the request
        $form->handleRequest($request);

        // If the form is in POST and it is valid
        if ($request->getMethod() == "POST" && $form->isValid()) {
            // Saving changes
            $em = ConfigHandler::get("entityManager");
            $em->persist($faq);
            $em->flush();
            // Redirection to the home page
            $this->redirect->redirectToRoute("admin_faq_list");
        }

        // Otherwise if there is no receipt of request, display of the edit view
        return $this->renderer->render("admin/faq/new", [
            'form' => $form->createView(),
            'title' => "Modification d'une Question/Réponse"
        ]);
    }

    /**
     * Delete a question
     * @param Faq $faq
     * @throws \Exception
     */
    public function delete(Faq $faq)
    {
        // Delete the question
        $em = ConfigHandler::get("entityManager");
        $em->from('faq')->delete($faq->getId());
        // Redirection to the home page
        $this->redirect->redirectToRoute("admin_faq_list");
    }
}