<?php

namespace App\Controllers;

use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\Faq;
use App\Repository\FaqRepository;

class FaqController extends BaseController
{
    /**
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
        return $this->renderer->render("faq/index", [
            'questions' => $questions,
            'title' => 'Liste des Question / Réponse'
        ]);
    }
}