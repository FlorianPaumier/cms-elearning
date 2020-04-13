<?php


namespace App\Controllers\Admin;


use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Form\LessonForm;

class LessonController extends BaseController
{

    public function index()
    {
        $lessons = $this->repository->from("lesson")->findAll();

        return $this->renderer->render("admin/lessons/lesson", [
            "lessons" => $lessons,
            'title' => "Listes des Cours"
        ]);
    }

    public function new(Request $request){
        $form = (new LessonForm())->buildForm();

        return $this->renderer->render("admin/lessons/new", [
            "form" => $form->createView(),
            'title' => "Création d'un Cour"
        ]);
    }
}