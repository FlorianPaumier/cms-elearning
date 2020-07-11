<?php

namespace App\Controllers\Frontend;

use App\Core\Cache\ConfigHandler;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\Article;
use App\Form\ArticleForm;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\CommentaryRepository;

class ArticleController extends BaseController
{
    public function index(ArticleRepository $repository)
    {
        $articles = $repository->paginate(5);

        return $this->renderer->render("frontend/article/index",[
            "articles" => $articles,
            "title" => "Liste d'articles"
        ]);
    }

    public function view(Request $request, ArticleRepository $repository,Article $article, CategoryRepository $category, CommentaryRepository $commentary)
    {
        $comments = $commentary->findBy(['id_article' => $article->getId()]);
        $category = $category->findBy(['id' => $article->getIdCategory()]);

        return $this->renderer->render("frontend/article/view", [
            "category" => $category,
            "commentary" => $comments,
            "article" => $article,
            "title" => "Modification de l'article"
        ]);
    }
}