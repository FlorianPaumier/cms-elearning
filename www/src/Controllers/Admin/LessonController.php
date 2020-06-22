<?php


namespace App\Controllers\Admin;


use App\Core\Cache\ConfigHandler;
use App\Core\Database\Hydrator;
use App\Core\Database\Table;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\Lesson;
use App\Entity\LessonChapter;
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

        if ($request->getMethod() == "POST" && $form->isValid()) {
            /** @var Table $em */
            $em = ConfigHandler::get("repository");
            $em->persist($lesson);
            $em->flush();
            $this->redirect->redirectToRoute("admin_lesson_list");
        }


        return $this->renderer->render("admin/lessons/new", [
            "form" => $form->createView(),
            'title' => "Création d'un Cour"
        ]);
    }

    public function edit(Request $request, Lesson $lesson)
    {
        $chapters = $this->repository
            ->from("lesson_chapter", "lc")
            ->select("id","title")
            ->join("INNER JOIN", "lesson on lc.lesson_id = lesson.id")
            ->where("lesson.id = :id")
            ->setParam("id", $lesson->getId())
            ->fetchOrFail();

        foreach ($chapters as $chapter){
            $lesson->addChapters(Hydrator::hydrate($chapter, LessonChapter::class));
        }

        $form = $this->createForm(LessonForm::class, $lesson);
        $form->handleRequest($request);

        if ($request->getMethod() == "POST" && $form->isValid()) {
            $em = ConfigHandler::get("repository");
            $em->persist($lesson);
            $em->flush();
            $this->redirect->redirectToRoute("admin_lesson_list");
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