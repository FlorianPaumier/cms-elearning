<?php


namespace App\Controllers\Admin;


use App\Core\Cache\ConfigHandler;
use App\Core\Database\Table;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\LessonChapter;
use App\Entity\Lesson;
use App\Form\ChapterForm;
use App\Form\LessonForm;

class LessonChapterController extends BaseController
{

    public function index()
    {
        $this->repository->getClass(LessonChapter::class);
        $chapters = $this->repository->findAll();

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
            /** @var Table $em */
            $em = ConfigHandler::get("repository");
            $em->persist($chapter);
            $em->flush();
            $this->redirect->redirectToRoute("admin_chapter_list");
        }


        return $this->renderer->render("admin/chapters/form", [
            "form" => $form->createView(),
            'title' => "Création d'un Cour"
        ]);
    }

    public function edit(Request $request, LessonChapter $chapter)
    {
        $form = $this->createForm(ChapterForm::class, $chapter);
        $form->handleRequest($request);

        if ($request->getMethod() == "POST" && $form->isValid()) {
            $em = ConfigHandler::get("repository");
            $em->persist($chapter);
            $em->flush();
            $this->redirect->redirectToRoute("admin_chapter_list");
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