<?php


namespace App\Form;


use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\ButtonType;
use App\Core\Form\Fields\CheckboxType;
use App\Core\Form\Fields\CollectionType;
use App\Core\Form\Fields\EmailType;
use App\Core\Form\Fields\IntegerType;
use App\Core\Form\Fields\PasswordType;
use App\Core\Form\Fields\RadioType;
use App\Core\Form\Fields\SubmitType;
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
            ->add("slogan", TextType::class, [
                "label" => "Petit slogan pour expliquer votre site",
                "required" => false,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->add("email", EmailType::class, [
                "label" => "Email",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->add("server_mail_host", TextType::class, [
                "label" => "Serveur Mail",
                "required" => false,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->add("server_mail_port", IntegerType::class, [
                "label" => "Port du Serveur",
                "required" => false,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->add("server_mail_identifiant", EmailType::class, [
                "label" => "Serveur identifiant",
                "required" => false,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->add("server_mail_password", PasswordType::class, [
                "label" => "Serveur mot de passe",
                "required" => false,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->add("server_mail_test", ButtonType::class, [
                "label" => "Tester les informations",
                "type" => "button",
                "required" => false,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->add("maintenance", RadioType::class, [
                "label" => "Maintenance",
                "required" => false,
                "class" => "col-md-6 col-lg-6 col-sm-12",
                "choices" => [
                    true => "Oui",
                    false => "Non"
                ]
            ])
            ->add("indexation", CheckboxType::class, [
                "label" => "Visibilité pour les moteurs de recherche",
                "required" => false,
                "class" => "col-md-6 col-lg-6 col-sm-12",
                "choices" => [
                    true => "Oui",
                ]
            ])
            ->add("valider", SubmitType::class, [
                "label" => "Valider",
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