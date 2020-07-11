<?php


namespace App\Form;


use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\ButtonType;
use App\Core\Form\Fields\EntityType;
use App\Core\Form\Fields\TextAreaType;
use App\Core\Form\Fields\TextType;
use App\Core\Form\FormBuilder;
use App\Entity\Article;
use App\Entity\Category;

class CategoryForm extends AbstractForm
{
    public static function getConstraint(): array
    {
        return [
            [
                "category" => [
                    "empty" => false,
                    "required" => true,
                    "exists" => true,
                ]
            ],
        ];
    }

    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder
            ->add("category", TextType::class,[
                "label" => "Titre",
                "placeholder" => "Titre",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->add("valider", ButtonType::class, [
                "label" => "Valider",
                "class" => "btn-submit",
                "type" => "submit",
            ]);
    }

    public function setBlockPrefix(string $prefix = null): void
    {
        $this->prefix = $prefix;
    }

    public function getBlockPrefix(): string
    {
        return "admin_category";
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(){
        $this->options = [
            "data_class" => Category::class
        ];
    }
}