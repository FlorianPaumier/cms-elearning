<?php


namespace App\Form;


use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\ButtonType;
use App\Core\Form\Fields\TextType;
use App\Core\Form\FormBuilder;
use App\Entity\Category;

class CategoryForm extends AbstractForm
{
    /**
     * @param FormBuilder $builder
     * @return FormBuilder
     * @throws \Exception
     */
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

    /**
     * @param string|null $prefix
     */
    public function setBlockPrefix(string $prefix = null): void
    {
        $this->prefix = $prefix;
    }

    /**
     * @return string
     */
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