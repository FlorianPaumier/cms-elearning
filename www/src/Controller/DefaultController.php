<?php

namespace App\Controller;

use App\Core\Renderer\RenderView;

class DefaultController
{

    public function index()
    {
        (new RenderView())->render("home");
    }
}