<?php


namespace App\Form;


use App\Core\Form\FormBuilder;
use App\Core\Interfaces\FormTypeInterface;

class LessonForm extends FormBuilder implements FormTypeInterface
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
            ->input("title", [
                "label" => "Title",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->textarea("description", [
                "label" => "Description",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12 ckeditor",
            ])
            ->collection("chapters", ChapterForm::class, [
                "label" => "Chapitre",
                "require" => false,
                "class" => "col-md-6 col-lg-6 col-sm-12",
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
        $this->prefix = "admin_lesson";
    }

    public function getBlockPrefix(): string
    {
        return $this->prefix;
    }
}