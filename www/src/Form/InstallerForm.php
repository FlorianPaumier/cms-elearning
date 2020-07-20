<?php


namespace App\Form;


use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\ButtonType;
use App\Core\Form\Fields\CheckboxType;
use App\Core\Form\Fields\ImageType;
use App\Core\Form\Fields\SelectType;
use App\Core\Form\Fields\TextAreaType;
use App\Core\Form\Fields\TextType;
use App\Core\Form\FormBuilder;
use App\Entity\Article;
use App\Repository\CategoryRepository;

class InstallerForm extends AbstractForm
{
    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder

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