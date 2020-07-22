<?php

namespace App\Controllers;

use App\Core\Cache\ConfigHandler;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\Sondage;
use App\Entity\SondageVote;
use App\Repository\SondageRepository;
use App\Repository\SondageVoteRepository;

class SondageController extends BaseController
{
    /**
     * Home Survey
     * @param SondageRepository $sondageRepository
     * @param SondageVoteRepository $sondageVoteRepository
     * @return \App\Core\Render\RenderView|string|string[]|null
     * @throws \Exception
     */
    public function index(SondageRepository $sondageRepository,  SondageVoteRepository $sondageVoteRepository)
    {
        // Get the surveys
        $sondages = $sondageRepository->findAll();

        // Return the home view with surveys, userId and the repository of survey vote
        return $this->renderer->render("sondage/index", [
            'sondages' => $sondages,
            'userId' => $this->getUser()->getId(),
            'sondageVoteRepository' => $sondageVoteRepository,
            'title' => 'Liste des sondages',
        ]);
    }

    /**
     * Vote a survey
     * @param Request $request
     * @param Sondage $sondage
     * @param SondageRepository $sondageRepository
     * @param SondageVoteRepository $sondageVoteRepository
     * @return \App\Core\Render\RenderView|string|string[]|null
     * @throws \Exception
     */
    public function vote(Request $request, Sondage $sondage, SondageRepository $sondageRepository, SondageVoteRepository $sondageVoteRepository)
    {
        // Initialization of a new survey vote
        $sondageVote = new SondageVote();

        // If the form is in POST
        if ($request->getMethod() == "POST") {
            // Assigning the voting choice to the object SondageVote
            $sondageVote->setSondage($sondage)->setChoix(intval($request->get("option")))->setUser($this->getUser());

            // Saving the vote
            /** @var Table $em */
            $em = ConfigHandler::get("entityManager");
            $em->persist($sondageVote);
            $em->flush();
            // Redirection to the home page
            $this->redirect->redirectToRoute("frontend_sondage_list");
        }

        // Get the surveys
        $sondages = $sondageRepository->findAll();

        // Return the home view with surveys, userId and the repository of survey vote
        return $this->renderer->render("sondage/index", [
            'sondages' => $sondages,
            'userId' => $this->getUser()->getId(),
            'sondageVoteRepository' => $sondageVoteRepository,
            'title' => 'Liste des sondages'
        ]);
    }
}