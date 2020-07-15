<?php

namespace App\Controllers\Frontend;

use App\Core\Cache\ConfigHandler;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\Article;
use App\Entity\Commentary;
use App\Form\CommentaryForm;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\CommentaryRepository;

class ArticleController extends BaseController
{
    public function index(ArticleRepository $repository)
    {
        $articles = $repository->where("visible = true")->paginate(5);

        return $this->renderer->render("frontend/article/index",[
            "articles" => $articles,
            "title" => "Liste d'articles"
        ]);
    }

    public function view(Request $request, ArticleRepository $repository,Article $article, CategoryRepository $category, CommentaryRepository $commentary)
    {
        if(!$article->getVisible()){
            $this->redirect->redirectToRoute("article_list");
        }

        $comment = new Commentary();

        $commentForm = $this->createForm(CommentaryForm::class, $comment);
        $commentForm->handleRequest($request);

        if($request->getMethod() == "POST" && $commentForm->isValid()) {
            $em = ConfigHandler::get("entityManager");
            $em->persist($comment);
            $em->flush();
            $this->redirect->redirectToRoute("article_view", ['id' =>$article->getId()]);
        }

        $comments = $commentary->findBy(['id_article' => $article->getId()]);
        $category = $category->findBy(['id' => $article->getIdCategory()]);

        return $this->renderer->render("frontend/article/view", [
            "commentaryForm" => $commentForm->createView(),
            "category" => $category,
            "commentary" => $comments,
            "article" => $article,
            "title" => "Modification de l'article"
        ]);
    }
}