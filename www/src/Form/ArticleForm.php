<?php


namespace App\Form;


use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\ButtonType;
use App\Core\Form\Fields\CheckboxType;
use App\Core\Form\Fields\ImageType;
use App\Core\Form\Fields\RadioType;
use App\Core\Form\Fields\SelectType;
use App\Core\Form\Fields\TextAreaType;
use App\Core\Form\Fields\TextType;
use App\Core\Form\FormBuilder;
use App\Entity\Article;
use App\Repository\CategoryRepository;

class ArticleForm extends AbstractForm
{
    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder
            ->add("image", ImageType::class, [
                "label" => "Image",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->add("visible", CheckboxType::class, [
                "label" => "",
                "required" => false,
                "class" => "col-md-6 col-lg-6 col-sm-12",
                "choices" => [ 1 => 'visible' ]
            ])
            ->add("title", TextType::class,[
                "label" => "Titre",
                "placeholder" => "Titre",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->add("idCategory", SelectType::class, [
                "label" => "Catégorie",
                "placeholder" => "Catégorie",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
                "choices" => (new CategoryRepository())->findCategories()
            ])
            ->add("content", TextAreaType::class, [
                "label" => "Contenu",
                "placeholder" => "Contenu",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12 ckeditor",
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
        return "admin_article";
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(){
        $this->options = [
            "data_class" => Article::class
        ];
    }
}