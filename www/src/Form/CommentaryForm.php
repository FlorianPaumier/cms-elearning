<?php

namespace App\Form;


use App\Core\Form\FormType;

class CommentaryForm extends FormType
{
    /**
     * @return array|void
     */
    public static function getConstraint()
    {
        return [
            [
                "commentary" => [
                    "empty" => false,
                    "required" => true,
                ]
            ]
        ];
    }

    public function buildForm()
    {
        $this->formBuilder
            ->input(
                "commentary", "commentary", true, [
                    "class" => "form-control form-control-user"
                ]
            )
            ->button(
                "submit", "Répondre", [
                    "type" => "submit",
                    "class" => "btn btn-primary btn-commentary btn-block"
                ]
            );

        return $this->formBuilder;
    }

    public function getBlockPrefix()
    {
        $this->prefix = "app_commentary";
    }
}