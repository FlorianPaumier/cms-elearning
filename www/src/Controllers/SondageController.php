<?php

namespace App\Controllers;

use App\Core\Cache\ConfigHandler;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\Sondage;
use App\Entity\SondageVote;
use App\Repository\SondageRepository;

class SondageController extends BaseController
{
    public function index(SondageRepository $sondageRepository)
    {
        $questions = $sondageRepository->findAll();

        return $this->renderer->render("sondage/index", [
            'questions' => $questions,
            'title' => 'Liste des sondages'
        ]);
    }

    public function vote(Request $request, SondageRepository $sondageRepository)
    {
        $sondageVote = new SondageVote();

        if ($request->getMethod() == "POST") {
            $sondageVote->setIdVote(intval($request->get("id")));
            $sondageVote->setChoix(intval($request->get("option")));

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