<?php

namespace App\Form;

use App\Core\Form\FormBuilder;
use App\Core\Interfaces\FormTypeInterface;

class UserForgetpasswordForm extends FormBuilder implements FormTypeInterface
{

    public static function getConstraint(): array
    {
        return
            [
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
            ->input("email", [])
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
        $this->prefix = "app_forget_password";
    }
}
