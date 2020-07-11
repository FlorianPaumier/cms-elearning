<?php


namespace App\Controllers\Frontend;


use App\Core\Evaluation\Evaluation;
use App\Core\Evaluation\EvaluationInput;
use App\Core\Evaluation\EvaluationMeta;
use App\Core\Evaluation\EvaluationObject;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\Sondage;
use App\Repository\EvaluationInputRepository;

class EvaluationController extends BaseController
{

    public function index(Request $request, Evaluation $evaluation, EvaluationInputRepository $repository)
    {
        $form = $this->createForm($evaluation->getPath());
        $form->handleRequest($request);

        if($form->isValid()){
            $data = $request->getRequest()->all();

            $eval = new EvaluationObject();
            $eval->setEvaluation($evaluation);
            $eval->setName($evaluation->getName());
            $eval->setUser($this->getUser());
            $this->entityManager->persist($eval);

            $fields = [];

            foreach ($data as $key => $value) {
                $field = new EvaluationMeta();
                $name = explode("_",$key);
                $inputRepo = new EvaluationInputRepository();

                /** @var EvaluationInput $input */
                $input = $inputRepo->findOneBy([
                    "form_key" => end($name),
                    "evaluation_id" => $evaluation->getId()
                ]);

                if($input->getType() == "submit"){
                    continue;
                }

                $field->setInput($input);
                $field->setValue($value);

                $fields[end($name)] = $value;

                $field->setEvaluationObject($eval);
                $this->entityManager->persist($field);
            }

            $this->entityManager->flush();
            $this->redirect->redirectToRoute("frontend_form_contact");
        }

        return $this->render("frontend/evaluation/index", [
            "form" => $form->createView(),
        ]);
    }
}