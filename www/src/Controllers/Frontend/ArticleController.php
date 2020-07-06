<?php

namespace App\Controllers\Frontend;

use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\Article;
use App\Form\ArticleForm;

class ArticleController extends BaseController
{
    public function index(Request $request)
    {
        return $this->renderer->render("admin/article/article",[
            "method" => $request->getMethod(),
            "title" => "Index"
        ]);
    }

    public function list()
    {
        return $this->renderer->render("admin/article/article_list",[
            "title" => "Liste d'article"
        ]);
    }

    public function create()
    {
        $form = $this->createForm(ArticleForm::class);
        return $this->renderer->render("admin/article/article_create",[
            "title" => "Création d'article",
            "form" => $form->createView()
        ]);
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