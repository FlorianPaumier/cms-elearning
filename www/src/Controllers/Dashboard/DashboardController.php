<?php

namespace App\Controllers\Dashboard;

use App\Core\Interfaces\BaseController;
use App\Entity\User;
use App\Repository\UserRepository;

class DashboardController extends BaseController
{
    public function index(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();
        $statsUser = ['data' => [],
                     'total' => count($users)??0,
        ];
        foreach ($users as $user){
            $created_at = $user->getCreatedAt()->format('Y-m-d');
            $statsUser["data"][$created_at] = is_int($statsUser["data"][$created_at])?$statsUser["data"][$created_at]+1:1;

        }



        return $this->renderer->render("admin/dashboard/dashboard",
        [
            'user' => $this->getUser(),
            'statsUser' => $statsUser,
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