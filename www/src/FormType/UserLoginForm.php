<?php

namespace App\Form;


use App\Core\Form\FormType;

class UserLoginForm extends FormType
{
    /**
     * @return array|void
     */
    public static function getConstraint()
    {
        return [
            [
                "username" => [
                    "empty" => false,
                    "required" => true,
                    "exists" => true,
                ]
            ],
            [
                "password" => [
                    "empty" => false,
                    "required" => true,
                    "exists" => true,
                ]
            ]
        ];
    }

    public function buildForm()
    {
        $this->formBuilder
            ->input(
                "username", "username", true, [
                "class" => "form-control form-control-user"
                ]
            )
            ->input(
                "password", "password", true, [
                "class" => "form-control form-control-user"
                ]
            )
            ->button(
                "submit", "Se connecter", [
                "type" => "submit",
                "class" => "btn btn-primary btn-user btn-block"
                ]
            );

        return $this->formBuilder;
    }

    public function getBlockPrefix()
    {
        $this->prefix = "app_login";
    }
}