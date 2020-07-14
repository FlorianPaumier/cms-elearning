<?php


namespace App\Form;


use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\CollectionType;
use App\Core\Form\Fields\RadioType;
use App\Core\Form\Fields\TextAreaType;
use App\Core\Form\Fields\TextType;
use App\Core\Form\FormBuilder;
use App\Core\Interfaces\FormTypeInterface;

class ConfigurationForm extends AbstractForm
{

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder
            ->add("title", TextType::class,[
                "label" => "Titre",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->add("email", TextType::class, [
                "label" => "Email",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->add("maintenance", RadioType::class, [
                "label" => "Maintenance",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
                "choices" => [
                    true => "Oui",
                    false => "Non"
                ]
            ])
            ->add("valider", TextType::class, [
                "label" => "Valider",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ;
    }

    /**
     * @inheritDoc
     */
    public function setBlockPrefix(string $prefix = null): void
    {
        $this->prefix = $prefix;
    }

    public function getBlockPrefix(): string
    {
        return $this->prefix ?? "admin_configuration";
    }
}