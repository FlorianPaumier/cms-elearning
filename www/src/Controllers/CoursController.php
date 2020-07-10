<?php


namespace App\Controllers;


use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\Lesson;
use App\Entity\LessonChapter;
use App\Entity\LessonChapterBlock;
use App\Repository\LessonChapterRepository;
use App\Repository\LessonRepository;

class CoursController extends BaseController
{
    public function index(LessonRepository $repository){
        $lessons = $repository->paginate(20);
        return $this->renderer->render("lessons/index", ["lessons" => $lessons]);
    }

    public function show(Request $request, Lesson $lesson, LessonChapterRepository $chapterRepository)
    {
        $chapters = $chapterRepository
            ->orderBy("position", "ASC")
            ->findBy(["lesson_id" => $lesson->getId()]);


        return $this->render("lessons/show", [
            "lesson" => $lesson,
            "chapters" => $chapters,
            "chapter" => $request->get("chapter"),
            "end" => count($chapters),
        ]);
    }
}