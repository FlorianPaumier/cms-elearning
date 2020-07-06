<?php


namespace App\Controllers\Admin;


use App\Core\Cache\ConfigHandler;
use App\Core\Database\Hydrator;
use App\Core\Database\EntityManager;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\Lesson;
use App\Entity\LessonChapter;
use App\Form\LessonForm;
use App\Repository\LessonChapterRepository;
use App\Repository\LessonRepository;

class LessonController extends BaseController
{

    public function index(LessonRepository $repository)
    {
        $lessons = $repository->paginate(5);

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
            /** @var EntityManager $em */
            $em = ConfigHandler::get("entityManager");
            $em->persist($lesson)->flush();
            $this->redirect->redirectToRoute("admin_lesson_list");
        }


        return $this->renderer->render("admin/lessons/new", [
            "form" => $form->createView(),
            "errors" => $form->getErrorFeedback(),
            'title' => "Création d'un Cour"
        ]);
    }

    public function edit(Request $request,LessonRepository $repository, Lesson $lesson)
    {
        $lesson = $repository
            ->leftJoin("lesson_chapter", "lc")
            ->where("lesson.id = :id")
            ->setParameter("id", $lesson->getId())
            ->fetch();

        $form = $this->createForm(LessonForm::class, $lesson);
        $form->handleRequest($request);

        if ($request->getMethod() == "POST" && $form->isValid()) {
            /** @var EntityManager $em */
            $em = ConfigHandler::get("entityManager");
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