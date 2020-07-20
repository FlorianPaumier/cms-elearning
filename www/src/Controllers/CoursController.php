<?php


namespace App\Controllers;


use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\Lesson;
use App\Entity\LessonChapter;
use App\Entity\LessonChapterBlock;
use App\Entity\UserLesson;
use App\Repository\EvaluationRepository;
use App\Repository\LessonChapterRepository;
use App\Repository\LessonRepository;
use App\Repository\UserLessonRepository;

class CoursController extends BaseController
{
    public function index(LessonRepository $repository)
    {
        $lessons = $repository->paginate(20);
        return $this->renderer->render("lessons/index", ["lessons" => $lessons]);
    }

    public function show(Request $request, Lesson $lesson, LessonChapterRepository $chapterRepository, UserLessonRepository $userLessonRepository)
    {
        $navs = $this->getNav($lesson, $chapterRepository, $userLessonRepository);

        return $this->render("lessons/show", [
            "lesson" => $lesson,
            "chapters" => $navs["chapters"],
            "chapter" => $request->get("chapter"),
            "end" => count($navs["chapters"]),
            "nav" => $navs["nav"],
            "lessonUser" => count($navs["lessonUsers"]),
        ]);
    }

    public function notation(Lesson $lesson, EvaluationRepository $repository, LessonChapterRepository $chapterRepository, UserLessonRepository $userLessonRepository)
    {
        $evals = $repository->findBy(["lesson_id" => $lesson->getId(), "enabled" => true]);
        $navs = $this->getNav($lesson, $chapterRepository, $userLessonRepository);

        return $this->render("lessons/notations", [
            "evaluations" => is_array($evals) ? $evals : [$evals],
            "lesson" => $lesson,
            "nav" => $navs["nav"],
            "chapters" => $navs["chapters"],
        ]);
    }

    public function management(Request $request, Lesson $lesson, UserLessonRepository $userLessonRepository)
    {
        $option = $request->getRequest()->get("option");
        $chapter = $request->getRequest()->get("chapter");

        $userLesson = null;

        $userLesson = $userLessonRepository->findOneBy(["lesson_id" => $lesson->getId(), "user_id" => $this->getUser()->getId(), "chapter" => $chapter]);

        if(!is_null($userLesson)){
            header('Status: 200 Sucess', false, 200);
            return json_encode(["message" => true]);
        }

        $userLesson = (new UserLesson())
            ->setUser($this->getUser())
            ->setLesson($lesson)
            ->setIsOver(false)
            ->setChapter($chapter);

        if ($option == "over") {
            $userLesson->setIsOver(true);
        }

        if (!is_null($userLesson)) {
            $this->entityManager->persist($userLesson)->flush();
        } else {
            header('Status: 500 Server Error', false, 500);
            return json_encode(["message" => "Une erreur est survenue, veuillez retenter ou contacter un administrateur"]);
        }


        header('Status: 200 Sucess', false, 200);
        return json_encode(["message" => true]);

    }

    private function getNav(Lesson $lesson, LessonChapterRepository $chapterRepository, UserLessonRepository $lessonRepository)
    {
        /** @var LessonChapter[] $chapters */
        $chapters = $chapterRepository
            ->orderBy("position", "ASC")
            ->findBy(["lesson_id" => $lesson->getId()]);

        /** @var UserLesson[] $lessonUsers */
        $lessonUsers =$lessonRepository->findBy(["lesson_id" => $lesson->getId(), "user_id" => $this->getUser()->getId()]);

        $nav=[];

        foreach ($chapters as $chapter){
            foreach ($lessonUsers as $lessonUser){
                if($lessonUser->getChapter() == $chapter->getPosition()){
                    $nav[$chapter->getId()] = [
                        "chapter" => $chapter,
                        "active" => true,
                    ];
                }
            }

            if(!key_exists($chapter->getId(), $nav)){
                $nav[$chapter->getId()] = [
                    "chapter" => $chapter,
                    "active" => false,
                ];
            }
        }

        return [
            "chapters" => $chapters,
            "lessonUsers" => $lessonUsers,
            "nav" => $nav
        ];
    }
}