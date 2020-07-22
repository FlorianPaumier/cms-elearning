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
    /**
     * Home Survey
     * @param SondageRepository $sondageRepository
     * @return \App\Core\Render\RenderView|string|string[]|null
     * @throws \Exception
     */
    public function index(SondageRepository $sondageRepository)
    {
        // Get the surveys
        $sondages = $sondageRepository->findAll();
        // If there is at least one survey
        $sondages = !is_null($sondages) ? $sondages : [];

        // Return the home view with surveys
        return $this->renderer->render("admin/sondage/index", [
            'sondages' => $sondages,
            'title' => 'Liste des sondages'
        ]);
    }

    /**
     * Add a new survey
     * @param Request $request
     * @return \App\Core\Render\RenderView|string|string[]|null
     * @throws \Exception
     */
    public function new(Request $request)
    {
        // Initialization of a new survey
        $sondage = new Sondage();

        // Calling the addition form with the object Sondage
        $form = $this->createForm(SondageForm::class, $sondage);
        // Retrieves the parameters of the request
        $form->handleRequest($request);

        // If the form is in POST and it is valid
        if ($request->getMethod() == "POST" && $form->isValid()) {
            // Saving the question
            /** @var Table $em */
            $em = ConfigHandler::get("entityManager");
            $em->persist($sondage);
            $em->flush();
            // Redirection to the home page
            $this->redirect->redirectToRoute("admin_sondage_list");
        }

        // Otherwise if there is no receipt of request, display of the add view
        return $this->renderer->render("admin/sondage/new", [
            'form' => $form->createView(),
            'title' => "Création d'un sondage"
        ]);
    }

    /**
     * Edit a survey
     * @param Request $request
     * @param Sondage $sondage
     * @return \App\Core\Render\RenderView|string|string[]|null
     * @throws \Exception
     */
    public function edit(Request $request, Sondage $sondage)
    {
        // Calling the editing form with the object Sondage
        $form = $this->createForm(SondageForm::class, $sondage);
        // Retrieves the parameters of the request
        $form->handleRequest($request);

        // If the form is in POST and it is valid
        if ($request->getMethod() == "POST" && $form->isValid()) {
            // Saving changes
            $em = ConfigHandler::get("entityManager");
            $em->persist($sondage);
            $em->flush();
            // Redirection to the home page
            $this->redirect->redirectToRoute("admin_sondage_list");
        }

        // Otherwise if there is no receipt of request, display of the edit view
        return $this->renderer->render("admin/sondage/new", [
            'form' => $form->createView(),
            'title' => "Modification d'un sondage"
        ]);
    }

    /**
     * Delete a survey
     * @param Sondage $sondage
     * @throws \Exception
     */
    public function delete(Sondage $sondage)
    {
        // Delete the survey
        $em = ConfigHandler::get("entityManager");
        $em->from('sondage')->delete($sondage);
        // Redirection to the home page
        $this->redirect->redirectToRoute("admin_sondage_list");
    }
}