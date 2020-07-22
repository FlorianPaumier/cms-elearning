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
     * I
     * @param SondageRepository $sondageRepository
     * @param SondageVoteRepository $sondageVoteRepository
     * @return \App\Core\Render\RenderView|string|string[]|null
     * @throws \Exception
     */
    public function index(SondageRepository $sondageRepository,  SondageVoteRepository $sondageVoteRepository)
    {
        $sondages = $sondageRepository->findAll();

        return $this->renderer->render("sondage/index", [
            'sondages' => $sondages,
            'userId' => $this->getUser()->getId(),
            'sondageVoteRepository' => $sondageVoteRepository,
            'title' => 'Liste des sondages',
        ]);
    }

    public function vote(Request $request, Sondage $sondage, SondageRepository $sondageRepository, SondageVoteRepository $sondageVoteRepository)
    {
        $sondageVote = new SondageVote();

        if ($request->getMethod() == "POST") {
            $sondageVote->setSondage($sondage)->setChoix(intval($request->get("option")))->setUser($this->getUser());

            /** @var Table $em */
            $em = ConfigHandler::get("entityManager");
            $em->persist($sondageVote);
            $em->flush();
            $this->redirect->redirectToRoute("frontend_sondage_list");
        }

        $questions = $sondageRepository->findAll();

        return $this->renderer->render("sondage/index", [
            'questions' => $questions,
            'title' => 'Liste des sondages'
        ]);
    }
}