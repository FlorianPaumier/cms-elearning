<?php

namespace App\Controllers\Article;

use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;

class ArticleController extends BaseController
{
    public function index(Request $request)
    {
        return $this->renderer->render(ROOT_DIR . "/public/views/article/article",[
            "method" => $request->getMethod()
        ]);
    }

    public function list()
    {
        return $this->renderer->render("article/article_list");
    }

    public function create()
    {
        $this->renderer->render("article/article_list");
    }

    public function modify()
    {
        $this->renderer->render("article/article_list");
    }

    public function design()
    {
        $this->renderer->render("article/article_design");
    }
}