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

class InstallerDatabaseForm extends AbstractForm
{

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder
            ->add("server_database_driver", TextType::class,[
                "label" => "Driver",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->add("server_database_host", TextType::class, [
                "label" => "Host",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->add("server_database_port", IntegerType::class, [
                "label" => "Port",
                "required" => false,
                "class" => "col-md-6 col-lg-6 col-sm-12",
                "value" => null
            ])
            ->add("server_database_dbname", TextType::class, [
                "label" => "Database name",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->add("server_database_username", TextType::class, [
                "label" => "Username",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->add("server_database_password", PasswordType::class, [
                "label" => "Password",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->add("server_database_charset", TextType::class, [
                "label" => "Charset",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->add("server_database_prefix", TextType::class, [
                "label" => "Prefix",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->add("valider", SubmitType::class, [
                "label" => "Valider",
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ]);
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

    public function configureOptions()
    {
    }
}