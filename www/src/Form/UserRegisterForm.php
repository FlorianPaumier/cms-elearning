<?php

namespace App\Form;

use App\Core\Form\AbstractForm;
use App\Core\Form\FormBuilder;
use App\Core\Interfaces\FormTypeInterface;

class UserRegisterForm extends AbstractForm
{

    public static function getConstraint(): array
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

    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder;
    }

    public function getBlockPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * @inheritDoc
     */
    public function setBlockPrefix(string $prefix = null): void
    {
        $this->prefix = "app_register";
    }
}