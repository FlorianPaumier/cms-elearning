<?php


namespace App\Controllers\Admin;


use App\Core\Contact\ContactForm;
use App\Core\Contact\ContactInput;
use App\Core\Database\EntityManager;
use App\Core\Evaluation\Evaluation;
use App\Core\Evaluation\EvaluationInput;
use App\Core\Form\FormTypeBuilderServices;
use App\Core\Formatter\Serializer;
use App\Core\Helpers\StringTransformer;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Repository\ContactInputRepository;
use App\Repository\ContactFormRepository;
use App\Repository\EvaluationInputRepository;
use App\Repository\EvaluationRepository;
use App\Repository\LessonRepository;

class EvaluationController extends BaseController
{
    public function index(Request $request, EvaluationRepository $repository)
    {
        return $this->renderer->render("admin/evaluation/index", [
            "evaluations" => $repository->paginate(15)
        ]);
    }

    public function new(Request $request)
    {
        if($request->getMethod() == "POST" ){
            $formTypeBuilder = (new FormTypeBuilderServices($request->getRequest()->get("admin_evaluation")))->generateForm(EvaluationInput::class);

            $inputs = $formTypeBuilder->getInputs();
            $form = $formTypeBuilder->createFormTypeClass($request->getRequest()->all(), Evaluation::class);

            $form->setDescription($request->getRequest()->get("admin_evaluation_description"));
            $form->setLesson((new LessonRepository())->find($request->getRequest()->get("admin_evaluation_lesson")));
            $this->entityManager->persist($form);

            $this->entityManager->flush();

            /** @var EvaluationInput $input */
            foreach ($inputs as $input){
                $input->setEvaluation($form);
                $this->entityManager->persist($input);
            }

            $this->entityManager->flush();
            $this->redirect->redirectToRoute("admin_evaluation_list");
        }

        return $this->render("admin/evaluation/new", [
            "lessons" => (new LessonRepository())->findAll(),
        ]);
    }

    public function edit(Request $request,Serializer $serializer, Evaluation $evaluation, EvaluationInputRepository $evaluationInputRepository){
        $inputs = $evaluationInputRepository->orderBy("position", "ASC")->findBy(["evaluation_id" => $evaluation->getId()]);
        $json = $serializer->serialize($inputs, "json");

        if($request->getMethod() == "POST"){
            $formTypeBuilder = (new FormTypeBuilderServices($request->getRequest()->get("admin_evaluation")))->generateForm(EvaluationInput::class, $evaluation);

            $inputs = $formTypeBuilder->getInputs();
            $form = $formTypeBuilder->createFormTypeClass($request->getRequest()->all(),Evaluation::class, $evaluation);

            $this->entityManager->persist($form);
            /** @var ContactInput $input */
            foreach ($inputs as $input){
                $this->entityManager->persist($input);
            }
            $this->entityManager->flush();
            $this->redirect->redirectToRoute("admin_evaluation_list");
        }

        return $this->render("admin/evaluation/edit", [
            "inputs" => $json,
            "form" => $evaluation,
            "lessons" => (new LessonRepository())->findAll(),
        ]);
    }

    public function delete(Evaluation $evaluation)
    {
        $this->entityManager->delete($evaluation);
        $this->redirect->redirectToRoute("admin_evaluation_list");
    }
}