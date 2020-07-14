<?php


namespace App\Controllers\Admin;


use App\Core\Evaluation\Evaluation;
use App\Core\Evaluation\EvaluationMeta;
use App\Core\Evaluation\EvaluationObject;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Core\Router\Router;
use App\Repository\EvaluationMetaRepository;
use App\Repository\EvaluationObjectRepository;

class NotationController extends BaseController
{

    public function index(Request $request, Evaluation $evaluation, EvaluationObjectRepository $repository)
    {
        return $this->render("admin/notation/index", [
            "evaluations" => $repository->where("evaluation_id = :id")->setParameter("id", $evaluation->getId())->paginate("15")
        ]);
    }

    public function show(Request $request, EvaluationObject $evaluationObject)
    {
        return $this->render("admin/notation/show", [
            "evaluation" => $evaluationObject,
        ]);
    }

    public function edit(Request $request,EvaluationObject $evaluationObject, EvaluationMetaRepository $repository)
    {
        if($request->getMethod() == "POST"){
            $rate = $request->getRequest()->get("rating");
            $evaluationObject->setRating($rate);

            $this->entityManager->persist($evaluationObject)->flush();

            $this->redirect->redirectToRoute("admin_notation_index", ["id" => $evaluationObject->getEvaluation()->getId()]);
        }

        return $this->render("admin/notation/edit",  [
            "eval" => $evaluationObject->getEvaluation(),
            "evaluation" => $evaluationObject,
            "inputs" => $repository->findBy(["evaluation_object_id" => $evaluationObject->getId()]),
        ]);
    }

    public function delete(EvaluationObject $evaluationObject)
    {
        $this->entityManager->delete($evaluationObject);
        $this->redirect->getPreviousPath();
    }

}