<?php


namespace App\Form;


use App\Core\Form\FormBuilder;
use App\Core\Interfaces\FormTypeInterface;

class FaqForm extends FormBuilder implements FormTypeInterface
{

    /**
     * @inheritDoc
     */
    public static function getConstraint(): array
    {
        return [
            [
                "question" => [
                    "empty" => false,
                    "required" => true,
                    "exists" => true,
                    "unique" => true
                ]
            ],
            [
                "reponse" => [
                    "empty" => false,
                    "required" => true,
                    "exists" => true,
                    "unique" => false
                ]
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    public function buildForm(): FormBuilder
    {
        return $this
            ->textarea("question", [
                "label" => "Question",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12 ckeditor",
            ])
            ->textarea("reponse", [
                "label" => "Réponse",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12 ckeditor",
            ])
            ->button("valider", [
                "label" => "Valider",
                "class" => "btn btn-submit",
            ]);
    }

    /**
     * @inheritDoc
     */
    public function setBlockPrefix(): void
    {
        $this->prefix = "admin_faq";
    }

    public function getBlockPrefix(): string
    {
        return $this->prefix;
    }
}