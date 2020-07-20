<?php

namespace App\Controllers;

use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Form\ChapterBlockForm;
use App\Repository\UserRepository;

class DefaultController extends BaseController
{
    public function index(Request $request)
    {
        return $this->renderer->render("home", [
            "method" => $request->getMethod(),
        ]);
    }

    public function doc()
    {
        return $this->renderer->render("doc");
    }
}
