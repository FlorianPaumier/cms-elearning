<?php


namespace App\Controllers\Admin;


use App\Core\Cache\ConfigHandler;
use App\Core\Database\Table;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\Lesson;
use App\Form\LessonForm;

class LessonController extends BaseController
{

    public function index()
    {
        $this->repository->getClass(Lesson::class);
        $lessons = $this->repository->findAll();

        return $this->renderer->render("admin/lessons/lesson", [
            "lessons" => $lessons,
            'title' => "Listes des Cours"
        ]);
    }

    public function new(Request $request)
    {
        $lesson = new Lesson();

        $form = $this->createForm(LessonForm::class, $lesson);
        $form->handleRequest($request);

        dump($lesson);
        if ($request->getMethod() == "POST" && $form->isValid()) {
            /** @var Table $em */
            $em = ConfigHandler::get("repository");
            $em->persist($lesson);
            $em->flush();
            die;
        }


        return $this->renderer->render("admin/lessons/new", [
            "form" => $form->createView(),
            'title' => "Création d'un Cour"
        ]);
    }

    public function edit(Request $request, Lesson $lesson)
    {
        $form = $this->createForm(LessonForm::class, $lesson);
        $form->handleRequest($request);

        if ($request->getMethod() == "POST") {
            die;
        }


        return $this->renderer->render("admin/lessons/new", [
            "form" => $form->createView(),
            'title' => "Création d'un Cour"
        ]);
    }

    public function delete(Request $request, Lesson $lesson){

        $this->redirect->redirectToRoute("admin_lesson_index");
    }
}