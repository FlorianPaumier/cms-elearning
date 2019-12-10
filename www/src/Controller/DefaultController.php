<?php

namespace App\Controller;

use App\Core\Interfaces\BaseController;
use App\Core\Renderer\RenderView;
use App\Form\UserLoginForm;

class DefaultController extends BaseController
{

    public function index()
    {
        $form = $this->form->buildForm(UserLoginForm::class);

        (new RenderView())->render(
            "home", [
            "form" => $form->createView(),
            ]
        );
    }
}