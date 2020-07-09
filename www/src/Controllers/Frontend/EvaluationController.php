<?php


namespace App\Controllers\Frontend;


use App\Core\Evaluation\Evaluation;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Repository\EvaluationInputRepository;

class EvaluationController extends BaseController
{

    public function index(Request $request, Evaluation $evaluation, EvaluationInputRepository $repository)
    {
        $form = $this->createForm($evaluation->getPath());
        $form->handleRequest($request);

        if($form->isValid()){
            dump("Valide");
        }

        return $this->render("frontend/evaluation/index", [
            "form" => $form->createView(),
        ]);
    }
}