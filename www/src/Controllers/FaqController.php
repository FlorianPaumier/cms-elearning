<?php

namespace App\Controllers;

use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\Faq;
use App\Repository\FaqRepository;

class FaqController extends BaseController
{
    public function index(FaqRepository $faqRepository)
    {
        $questions = $faqRepository->findAll();
        $questions = !empty($questions) ? $questions : array();

        return $this->renderer->render("faq/index", [
            'questions' => $questions,
            'title' => 'Liste des Question / Réponse'
        ]);
    }
}