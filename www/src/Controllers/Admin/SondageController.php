<?php

namespace App\Controllers\Admin;

use App\Core\Cache\ConfigHandler;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\Sondage;
use App\Form\SondageForm;

class SondageController extends BaseController
{
    public function index()
    {
        $this->repository->getClass(Sondage::class);
        $questions = $this->repository->findAll();
        $questions = !empty($questions) ? $questions : [];

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
            $sondage->setDate(new \DateTime());
            /** @var Table $em */
            $em = ConfigHandler::get("repository");
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
            $em = ConfigHandler::get("repository");
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
        $em = ConfigHandler::get("repository");
        $em->from('sondage')->delete($sondage->getId());
        $this->redirect->redirectToRoute("admin_sondage_list");
    }
}