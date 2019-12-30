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
            ->input("username", "username", true)
            ->input("password", "passworrd", true);

        return $this->formBuilder;
    }

    public function getBlockPrefix()
    {
        $this->formBuilder->setPrefix("app_login");
    }
}