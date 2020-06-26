<?php


namespace App\Controllers;


use App\Core\Interfaces\BaseController;
use App\Entity\Lesson;
use App\Entity\LessonChapter;
use App\Entity\LessonChapterBlock;
use App\Repository\LessonChapterRepository;
use App\Repository\LessonRepository;

class CoursController extends BaseController
{
    public function index(){
        return $this->renderer->render("lessons/index");
    }

    public function show(Lesson $lesson, LessonChapterRepository $lessonChapterRepository)
    {
        $chapters = $lessonChapterRepository
            ->setAlias("lc")
            ->join(LessonChapterBlock::class, "lcb")
            ->where("lc.lesson_id = :id")
            ->setParameter("id", $lesson->getId())
            ->findAll();

        dump($chapters);

        return $this->render("lessons/show");
    }
}