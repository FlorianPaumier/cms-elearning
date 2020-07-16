<?php

namespace App\Controllers\Admin;

use App\Core\Cache\ConfigHandler;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\Sondage;
use App\Form\SondageForm;
use App\Repository\SondageRepository;

class SondageController extends BaseController
{
    public function index(SondageRepository $sondageRepository)
    {
        $questions = $sondageRepository->findAll();

        $questions = !is_null($questions) ? $questions : [];

        return $this->renderer->render("admin/sondage/index", [
            'questions' => $questions,
            'title' => 'Liste des sondages'
        ]);
    }

    public function new(Request $request)
    {
        $sondage = new Sondage();

        $form = $this->createForm(SondageForm::class, $sondage);
        $form->handleRequest($request);

        if ($request->getMethod() == "POST" && $form->isValid()) {
            /** @var Table $em */
            $em = ConfigHandler::get("entityManager");
            $em->persist($sondage);
            $em->flush();
            $this->redirect->redirectToRoute("admin_sondage_list");
        }

        return $this->renderer->render("admin/sondage/new", [
            'form' => $form->createView(),
            'title' => "Création d'un sondage"
        ]);
    }

    public function edit(Request $request, Sondage $sondage)
    {
        $form = $this->createForm(SondageForm::class, $sondage);
        $form->handleRequest($request);

        if ($request->getMethod() == "POST" && $form->isValid()) {
            $em = ConfigHandler::get("entityManager");
            $em->persist($sondage);
            $em->flush();
            $this->redirect->redirectToRoute("admin_sondage_list");
        }

        return $this->renderer->render("admin/sondage/new", [
            'form' => $form->createView(),
            'title' => "Modification d'un sondage"
        ]);
    }

    public function delete(Sondage $sondage)
    {
        $em = ConfigHandler::get("entityManager");
        $em->from('sondage')->delete($sondage);
        $this->redirect->redirectToRoute("admin_sondage_list");
    }
}