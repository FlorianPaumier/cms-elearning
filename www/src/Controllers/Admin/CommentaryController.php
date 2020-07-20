<?php

namespace App\Controllers\Admin;

use App\Core\Interfaces\BaseController;
use App\Core\Interfaces\Entity;
use App\Core\Request\Request;
use App\Entity\Commentary;
use App\Form\CommentaryForm;
use App\Repository\CommentaryRepository;
use App\Core\Cache\ConfigHandler;
use Exception;

class CommentaryController extends BaseController
{
    public function index(CommentaryRepository $repository)
    {
        $commentary = $repository->paginate(5);

        return $this->renderer->render("admin/commentary/index",[
            "commentary" => $commentary,
            "title" => "Liste des commentaires"
        ]);
    }

    public function delete(Request $request, Commentary $commentary)
    {
        $this->entityManager->delete($commentary);
        $this->redirect->redirectToRoute("admin_commentary_list");
    }
}