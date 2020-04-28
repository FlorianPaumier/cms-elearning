<?php


namespace App\Form;


use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\CollectionType;
use App\Core\Form\Fields\TextType;
use App\Core\Form\FormBuilder;
use App\Core\Interfaces\FormTypeInterface;

class ChapterForm extends AbstractForm
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
    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder
            ->add("name", TextType::class,[
                "label" => "Nom",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->add("position", TextType::class, [
                "label" => "position",
                "type" => "number",
                "require" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->add("blocks", CollectionType::class,  [
                "label" => "Contenu",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
                "entry_type" => ChapterBlockForm::class,
            ]);
    }

    /**
     * @inheritDoc
     */
    /**
     * @inheritDoc
     */
    public function setBlockPrefix(string $prefix = null): void
    {
        $this->prefix = $prefix;
    }

    public function getBlockPrefix(): string
    {
        return $this->prefix ?? "admin_chapter";
    }
}