<?php

namespace App\Controllers\Admin;

use App\Core\Interfaces\BaseController;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\ContactObjectRepository;
use App\Repository\LessonRepository;
use App\Repository\UserRepository;

class DashboardController extends BaseController
{
    public function index(UserRepository $userRepository, LessonRepository $lessonRepository, ArticleRepository $articleRepository, ContactObjectRepository $contacObjectRepository)
    {
        $users = $userRepository->findAll();
        $statsUser = ['data' => [],
                     'total' => count($users)??0,
        ];
        foreach ($users as $user){
            $created_at = $user->getCreatedAt()->format('d-m-Y');
            $statsUser["data"][$created_at] = is_int($statsUser["data"][$created_at])?$statsUser["data"][$created_at]+1:1;

        }

        $lessons = $lessonRepository->findAll();
        $statsLesson = ['data' => [],
            'total' => count($lessons)??0,
        ];
        foreach ($lessons as $lesson){
            $created_at = $lesson->getCreatedAt()->format('d-m-Y');
            $statsLesson["data"][$created_at] = is_int($statsLesson["data"][$created_at])?$statsLesson["data"][$created_at]+1:1;

        }

        $articles = $articleRepository->findAll();
        $statsArticle = ['data' => [],
            'total' => count($articles)??0,
        ];
        foreach ($articles as $article){
            $created_at = $article->getCreatedAt()->format('d-m-Y');
            $statsArticle["data"][$created_at] = is_int($statsArticle["data"][$created_at])?$statsArticle["data"][$created_at]+1:1;

        }

        $contacts = $contacObjectRepository->findAll();
        $statsContact = ['data' => [],
            'total' => count($contacts)??0,
        ];
        foreach ($contacts as $contact){
            $created_at = $article->getCreatedAt()->format('d-m-Y');
            $statsContact["data"][$created_at] = is_int($statsContact["data"][$created_at])?$statsContact["data"][$created_at]+1:1;

        }



        return $this->renderer->render("admin/dashboard/dashboard",
        [
            'user' => $this->getUser(),
            'statsUser' => $statsUser,
            'statsLesson' => $statsLesson,
            'statsArticle' => $statsArticle,
            'statsContact' => $statsContact,

        ]);
    }

    public function sidebar()
    {
        return $this->renderer->render(ROOT_DIR . "/public/views/partials/sidebar");
    }

    public function design()
    {
        return $this->renderer->render(ROOT_DIR . "/public/views/admin/dashboard/dashboard_design");
    }
}