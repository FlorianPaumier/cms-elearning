<?php


namespace App\Controllers\Commentary;


use App\Core\Interfaces\BaseController;
use App\Form\CommentaryForm;

class CommentaryController extends BaseController
{

    public function send()
    {
        $form = $this->form->buildForm(CommentaryForm::class);

    }

    public function modify()
    {
        $form = $this->form->buildForm(CommentaryForm::class);
    }

    public function delete()
    {

    }
}