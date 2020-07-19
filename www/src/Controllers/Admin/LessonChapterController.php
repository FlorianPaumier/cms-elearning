<?php


namespace App\Controllers\Admin;


use App\Core\Cache\ConfigHandler;
use App\Core\Database\EntityManager;
use App\Core\Database\Repository\AbstractRepository;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\LessonChapterBlock;
use App\Entity\LessonChapter;
use App\Entity\Lesson;
use App\Form\ChapterForm;
use App\Form\LessonForm;
use App\Repository\LessonChapterRepository;

class LessonChapterController extends BaseController
{

    public function index()
    {
        /** @var AbstractRepository $repository */
        $repository = $this->entityManager->getRepository(LessonChapterRepository::class);
        $chapters = $repository->paginate(10);

        return $this->renderer->render("admin/chapters/index", [
            "chapters" => $chapters,
            'title' => "Listes des Cours"
        ]);
    }

    public function new(Request $request)
    {
        $chapter = new LessonChapter();

        $form = $this->createForm(ChapterForm::class, $chapter);
        $form->handleRequest($request);

        if ($request->getMethod() == "POST" && $form->isValid()) {
            /** @var EntityManager $em */
            $em = ConfigHandler::get("entityManager");
            $em->persist($chapter);
            $em->flush();
            $this->redirect->redirectToRoute("admin_lesson_chapter_index");
        }


        return $this->renderer->render("admin/chapters/form", [
            "form" => $form->createView(),
            "errors" => $form->getErrorFeedback(),
            'title' => "Création d'un Cour"
        ]);
    }

    public function edit(Request $request, LessonChapter $chapter)
    {
        $form = $this->createForm(ChapterForm::class, $chapter);
        $form->handleRequest($request);

        if ($request->getMethod() == "POST" && $form->isValid()) {
            $em = ConfigHandler::get("entityManager");
            $em->persist($chapter);
            $em->flush();
            $this->redirect->redirectToRoute("admin_lesson_chapter_index");
        }


        return $this->renderer->render("admin/chapters/form", [
            "form" => $form->createView(),
            'title' => "Création d'un Cour"
        ]);
    }

    public function delete(Request $request, LessonChapter $chapter){

        $this->redirect->redirectToRoute("admin_chapter_index");
    }
}