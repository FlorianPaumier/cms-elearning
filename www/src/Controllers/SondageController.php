<?php

namespace App\Controllers;

use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\Sondage;
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
}