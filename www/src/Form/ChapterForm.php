<?php


namespace App\Form;


use App\Core\Form\FormBuilder;
use App\Core\Interfaces\FormTypeInterface;

class ChapterForm extends FormBuilder implements FormTypeInterface
{

    /**
     * @inheritDoc
     */
    public static function getConstraint(): array
    {
        return [
            [
                "title" => [
                    "empty" => false,
                    "required" => true,
                    "exists" => true,
                ]
            ],
            [
                "description" => [
                    "empty" => false,
                    "required" => true,
                    "exists" => true,
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
            ->input("name", [
                "label" => "Nom",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->input("position", [
                "label" => "Chapitre",
                "type" => "number",
                "require" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->collection("blocks", ChapterBlockForm::class,  [
                "label" => "Contenu",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ]);
    }

    /**
     * @inheritDoc
     */
    public function setBlockPrefix(): void
    {
        $this->prefix = "admin_lesson";
    }

    public function getBlockPrefix(): string
    {
        return $this->prefix;
    }
}