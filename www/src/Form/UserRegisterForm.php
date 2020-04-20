<?php

namespace App\Form;

use App\Core\Form\FormBuilder;
use App\Core\Interfaces\FormTypeInterface;

class UserRegisterForm extends FormBuilder implements FormTypeInterface
{

    public static function getConstraint(): array
    {
        return
            [
            "username" => [
                "empty" => false,
                "required" => true,
                "length" => [
                    "min" => 4,
                ],
                "unique" => [
                    "table" => "user",
                ],
            ],
            "password" => [
                "empty" => false,
                "required" => true,
                "confirmation" => true,
                "length" => [
                    "min" => 8,
                ],
            ],
            "email" => [
                "required" => true,
                "empty" => false,
            ],
        ]
        ;
    }

    public function buildForm(): FormBuilder
    {
        return $this
            ->input("username", [])
            ->input("email", [])
            ->input("password", [])
            ->input("password_confirm", [])
            ->button("submit", []);

    }

    public function getBlockPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * @inheritDoc
     */
    public function setBlockPrefix(): void
    {
        $this->prefix = "app_register";
    }
}
