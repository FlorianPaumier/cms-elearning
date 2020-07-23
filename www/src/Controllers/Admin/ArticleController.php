<?php

namespace App\Controllers\Admin;

use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\Article;
use App\Form\ArticleForm;
use App\Repository\ArticleRepository;
use App\Core\Cache\ConfigHandler;
use Exception;

class ArticleController extends BaseController
{
    /**
     * display the list of article
     *
     * @param Request $request
     * @return \App\Core\Render\RenderView|string|string[]|null
     * @throws Exception
     */
    public function index(Request $request)
    {
        return $this->renderer->render("admin/article/list",[
            "method" => $request->getMethod(),
            "title" => "Index"
        ]);
    }

    /**
     * display the list of article
     *
     * @param ArticleRepository $repository
     * @return \App\Core\Render\RenderView|string|string[]|null
     * @throws Exception
     */
    public function list(ArticleRepository $repository)
    {
        $articles = $repository->paginate(5);

        return $this->renderer->render("admin/article/list",[
            "articles" => $articles,
            "title" => "Liste d'articles"
        ]);
    }

    /**
     * display a form to create a new item and insert the data if exist
     *
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function new(Request $request)
    {
        $article = new Article();

        $form = $this->createForm(ArticleForm::class, $article);
        $form->handleRequest($request);

        if($form->isValid()) {
            $article->setUser($this->getUser());

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

    /**
     * display a form to edit an item and update the data if exist
     *
     * @param Request $request
     * @param ArticleRepository $repository
     * @param Article $articles
     * @return \App\Core\Render\RenderView|string|string[]|null
     * @throws \App\Core\Exception\NoRecordException
     */
    public function edit(Request $request, ArticleRepository $repository, Article $articles)
    {
        $article = $repository->findBy(['id' => $articles->getId()]);

        $form = $this->createForm(ArticleForm::class, $article);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = ConfigHandler::get("entityManager");
            $em->persist($article);
            $em->flush();
            $this->redirect->redirectToRoute("admin_article_list");
        }

        return $this->renderer->render("admin/article/edit", [
            "form" => $form->createView(),
            "title" => "Modification de l'article"
        ]);
    }

    /**
     * delete an item
     *
     * @param Article $article
     * @throws Exception
     */
    public function delete(Article $article)
    {
        $this->entityManager->delete($article);
        $this->redirect->redirectToRoute("admin_article_index");
    }

    /**
     * page of design
     *
     * @return \App\Core\Render\RenderView|string|string[]|null
     * @throws Exception
     */
    public function design()
    {
        return $this->renderer->render("admin/article/design",[
            "title" => "Design d'article"
        ]);
    }

}