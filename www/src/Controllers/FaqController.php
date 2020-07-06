<?php

namespace App\Controllers;

use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\Faq;

class FaqController extends BaseController
{
    public function index()
    {
        $this->repository->getClass(Faq::class);
        $questions = $this->repository->findAll();
        $questions = !empty($questions) ? $questions : array();

        return $this->renderer->render("faq/index", [
            'questions' => $questions,
            'title' => 'Liste des Question / Réponse'
        ]);
    }
}