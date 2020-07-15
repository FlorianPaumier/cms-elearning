<?php

namespace App\Controllers\Admin;

use App\Core\Interfaces\BaseController;
use App\Core\Interfaces\Entity;
use App\Core\Request\Request;
use App\Entity\Article;
use App\Form\ArticleForm;
use App\Repository\ArticleRepository;
use App\Core\Cache\ConfigHandler;
use Exception;

class ArticleController extends BaseController
{
    public function index(Request $request)
    {
        return $this->renderer->render("admin/article/article",[
            "method" => $request->getMethod(),
            "title" => "Index"
        ]);
    }

    public function list(ArticleRepository $repository)
    {
        $articles = $repository->paginate(5);

        return $this->renderer->render("admin/article/article_list",[
            "articles" => $articles,
            "title" => "Liste d'articles"
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function new(Request $request)
    {
        $article = new Article();

        $form = $this->createForm(ArticleForm::class, $article);
        $form->handleRequest($request);

        if($request->getMethod() == "POST" && $form->isValid()) {
            $em = ConfigHandler::get("entityManager");
            $em->persist($article);
            $em->flush();
            $this->redirect->redirectToRoute("admin_article_list");
        }

        return $this->renderer->render("admin/article/new",[
            "title" => "Création d'article",
            "form" => $form->createView(),
            "errors"=> $form->getErrorFeedback()
        ]);
    }

    public function edit(Request $request, ArticleRepository $repository, Article $articles)
    {
        $article = $repository->findBy(['id' => $articles->getId()]);
        dump($article);
        $form = $this->createForm(ArticleForm::class, $article);
        $form->handleRequest($request);

        if ($request->getMethod() == "POST" && $form->isValid()) {
            $em = ConfigHandler::get("entityManager");
            $em->persist($article);
            $em->flush();
            $this->redirect->redirectToRoute("admin_article_list");
        }

        return $this->renderer->render("admin/article/new", [
            "form" => $form->createView(),
            "title" => "Modification de l'article"
        ]);
    }

    public function delete(Request $request, Article $article)
    {
        $this->redirect->redirectToRoute("admin_article_index");
    }

    public function modify()
    {
        $article = new Article();
        $form = $this->createForm(ArticleForm::class, $article);
        return $this->renderer->render("admin/article/article_modify",[
            "title" => "Modification d'article"
        ]);
    }

    public function design()
    {
        return $this->renderer->render("admin/article/article_design",[
            "title" => "Design d'article"
        ]);
    }

    public function destroy()
    {

    }
}