<?php


namespace App\Form;

use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\TextType;
use App\Core\Form\FormBuilder;

class ChatForm extends AbstractForm
{

    public static function getConstraint(): array
    {
        return [
            [
                "message" => [
                    "empty" => false,
                    "required" => true,
                    "exists" => true,
                ]
            ]
        ];
    }

    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder
            ->add("message", TextType::class,[
                "label" => "Nom",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ]);
    }

    public function setBlockPrefix(string $prefix = null): void
    {
        $this->prefix = $prefix;
    }

    public function getBlockPrefix(): string
    {
        return $this->prefix ?? "chat";
    }
}