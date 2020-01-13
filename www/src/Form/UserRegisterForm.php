<?php

namespace App\Form;

use App\Core\Form\FormType;

class UserRegisterForm extends FormType
{

    public static function getConstraint()
    {
        return
            [
                "username" => [
                    "empty" => false,
                    "required" => true,
                    "length" => [
                        "min" => 4
                    ],
                    "unique" => [
                        "table" => "user"
                    ]
                ],
                "password" => [
                    "empty" => false,
                    "required" => true,
                    "confirmation" => true,
                    "length" => [
                        "min" => 8
                    ]
                ],
                "email" => [
                    "required" => true,
                    "empty" => false,
                ]
            ]
            ;
    }

    public function buildForm()
    {
        $this->formBuilder
            ->input("username", "username", true)
            ->input("email", "email", true)
            ->input("password", "password", true)
            ->input("password_confirm", "Confirmation", true);

        return $this->formBuilder;
    }

    public function getBlockPrefix()
    {
        $this->formBuilder->setPrefix("app_register");
    }
}