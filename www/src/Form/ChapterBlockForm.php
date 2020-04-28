<?php


namespace App\Form;


use App\Core\Form\FormBuilder;
use App\Core\Interfaces\FormTypeInterface;

class ChapterBlockForm extends FormBuilder implements FormTypeInterface
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
                "label" => "Nom",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->textarea("content",  [
                "label" => "Contenu",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12 ckeditor",
            ]);
    }

    /**
     * @inheritDoc
     */
    public function setBlockPrefix(string $prefix = null): void
    {
        $this->prefix = $prefix ?? "admin_chapter_block";
    }

    public function getBlockPrefix(): string
    {
        return $this->prefix;
    }
}