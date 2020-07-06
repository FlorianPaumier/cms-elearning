<?php

namespace App\Controllers;

use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\Sondage;

class SondageController extends BaseController
{
    public function index()
    {
        $questions = $this->entityManager->setEntity(Sondage::class)->findAll();

        return $this->renderer->render("sondage/index", [
            'questions' => $questions,
            'title' => 'Liste des sondages'
        ]);
    }
}