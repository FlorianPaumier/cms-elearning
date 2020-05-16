<?php

namespace App\Controllers\Admin;

use App\Core\Cache\ConfigHandler;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\Faq;
use App\Form\FaqForm;

class FaqController extends BaseController
{
    public function index()
    {
        $this->repository->getClass(Faq::class);
        $questions = $this->repository->findAll();

        return $this->renderer->render("admin/faq/index", [
            'questions' => $questions,
            'title' => 'Liste des Question / Réponse'
        ]);
    }

    public function new(Request $request)
    {
        $faq = new Faq();

        $form = $this->createForm(FaqForm::class, $faq);
        $form->handleRequest($request);

        if ($request->getMethod() == "POST" && $form->isValid()) {
            /** @var Table $em */
            $em = ConfigHandler::get("repository");
            $em->persist($faq);
            $em->flush();
            $this->redirect->redirectToRoute("admin_faq_list");
        }

        return $this->renderer->render("admin/faq/new", [
            'form' => $form->createView(),
            'title' => "Création d'une Question/Réponse"
        ]);
    }

    public function edit(Request $request, Faq $faq)
    {
        $form = $this->createForm(FaqForm::class, $faq);
        $form->handleRequest($request);

        if ($request->getMethod() == "POST" && $form->isValid()) {
            $em = ConfigHandler::get("repository");
            $em->persist($faq);
            $em->flush();
            $this->redirect->redirectToRoute("admin_faq_list");
        }

        return $this->renderer->render("admin/faq/new", [
            'form' => $form->createView(),
            'title' => "Modification d'une Question/Réponse"
        ]);
    }

    public function delete(Faq $faq)
    {
        $em = ConfigHandler::get("repository");
        $em->from('faq')->delete($faq->getId());
        $this->redirect->redirectToRoute("admin_faq_list");
    }
}