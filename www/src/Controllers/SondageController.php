<?php

namespace App\Controllers;

use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\Sondage;

class SondageController extends BaseController
{
    public function index()
    {
        $this->repository->getClass(Sondage::class);
        $questions = $this->repository->findAll();
        $questions = !empty($questions) ? $questions : array();

        return $this->renderer->render("sondage/index", [
            'questions' => $questions,
            'title' => 'Liste des sondages'
        ]);
    }
}