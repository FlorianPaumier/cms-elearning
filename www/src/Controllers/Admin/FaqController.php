<?php

namespace App\Controllers\Admin;

use App\Core\Interfaces\BaseController;
use App\Core\Interfaces\FormTypeInterface;
use App\Core\Request\Request;
use App\Form\FaqForm;

class FaqController extends BaseController
{
    public function index()
    {
        $questions = $this->repository->from('faq')->findAll();

        return $this->renderer->render("admin/faq/index", [
            'questions' => $questions,
            'title' => 'Liste des Question / Réponse'
        ]);
    }

    public function new(Request $request)
    {
        $form = (new FaqForm())->buildForm();

        if ($this->query->getMethod() == "POST") {
            $validator = $this->getValidator()->buildValidator(FaqForm::getConstraint()); // A corriger

            if ($validator->isValid()) {
                if ($this->repository->from('faq')->insert(['question'=>'test', 'reponse'=>'test', 'date_insert'=>'2020-04-20']) !== true) {
                    $this->session->set("app.flash", ["error" => 'Erreur lors de l\'ajout']);
                } else {
                    $this->redirect->redirectToRoute("admin_faq_list");
                }
            } else {
                $this->session->set("app.flash", ["error" => $validator->getErrors()]);
            }
        } else {
            return $this->renderer->render("admin/faq/new", [
                "form" => $form->createView(),
                'title' => "Création d'une Question / Réponse"
            ]);
        }
    }

    public function edit(Request $request)
    {
        $form = (new FaqForm())->buildForm();

        return $this->renderer->render("admin/faq/new", [
            "form" => $form->createView(),
            'title' => "Création d'une Question / Réponse"
        ]);

//        $this->repository->from('faq')->insert(['question'=>'test', 'reponse'=>'test', 'date_insert'=>'2020-04-20']);
    }

    public function delete(Request $request)
    {
        $form = (new FaqForm())->buildForm();

        return $this->renderer->render("admin/faq/new", [
            "form" => $form->createView(),
            'title' => "Création d'une Question / Réponse"
        ]);

//        $this->repository->from('faq')->insert(['question'=>'test', 'reponse'=>'test', 'date_insert'=>'2020-04-20']);
    }
}