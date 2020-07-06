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
    public function index(Request $request)
    {
        return $this->renderer->render("admin/commentary/commentary",[
            "method" => $request->getMethod(),
            "title" => "Index"
        ]);
    }

    public function list(CommentaryRepository $repository)
    {
        $commentary = $repository->paginate(5);

        return $this->renderer->render("admin/commentary/commentary_list",[
            "commentary" => $commentary,
            "title" => "Liste des commentaires"
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function new(Request $request)
    {
        $commentary = new Commentary();

        $form = $this->createForm(CommentaryForm::class, $commentary);
        $form->handleRequest($request);

        if($request->getMethod() == "POST" && $form->isValid()) {
            $em = ConfigHandler::get("entityManager");
            $em->persist($commentary)->flush();
            $this->redirect->redirectToRoute("admin_commentary_list");
        }

        return $this->renderer->render("admin/commentary/new",[
            "title" => "Création de commentaire",
            "form" => $form->createView(),
            "errors"=> $form->getErrorFeedback()
        ]);
    }

    public function edit(Request $request, CommentaryRepository $repository, Commentary $commentary)
    {
        $lesson = $repository
            ->leftJoin("article", "article")
            ->where("commentary.id = :id")
            ->setParameter("id", $commentary->getId())
            ->fetch();

        $form = $this->createForm(CommentaryForm::class, $commentary);
        $form->handleRequest($request);

        if ($request->getMethod() == "POST" && $form->isValid()) {
            $em = ConfigHandler::get("entityManager");
            $em->persist($commentary);
            $em->flush();
            $this->redirect->redirectToRoute("admin_commentary_list");
        }

        return $this->renderer->render("admin/commentary/edit", [
            "form" => $form->createView(),
            "title" => "Modification de commentaire"
        ]);
    }

    public function delete(Request $request, Commentary $commentary)
    {
        $this->redirect->redirectToRoute("admin_commentary_list");
    }
}