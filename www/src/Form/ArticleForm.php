<?php


namespace App\Form;


use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\ButtonType;
use App\Core\Form\Fields\CheckboxType;
use App\Core\Form\Fields\EntityType;
use App\Core\Form\Fields\ImageType;
use App\Core\Form\Fields\RadioType;
use App\Core\Form\Fields\SelectType;
use App\Core\Form\Fields\TextAreaType;
use App\Core\Form\Fields\TextType;
use App\Core\Form\FormBuilder;
use App\Entity\Article;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Exception;

class ArticleForm extends AbstractForm
{
    /**
     * @param FormBuilder $builder
     * @return FormBuilder
     * @throws Exception
     */
    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder
            ->add("image", ImageType::class, [
                "label" => "Image",
                "required" => false,
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
            ->add("category", EntityType::class, [
                "label" => "Catégorie",
                "choice_label" => "category",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
                "entry_type" => Category::class
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