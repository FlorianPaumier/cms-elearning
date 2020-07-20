<?php


namespace App\Form;


use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\DateType;
use App\Core\Form\Fields\EmailType;
use App\Core\Form\Fields\PasswordType;
use App\Core\Form\Fields\SubmitType;
use App\Core\Form\Fields\TextAreaType;
use App\Core\Form\Fields\TextType;
use App\Core\Form\FormBuilder;
use App\Entity\User;

class UserEditForm extends AbstractForm
{

    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder
            ->add("email", EmailType::class, [
                "unique" => true,
                "required" => true,
                "label" => "Email",
                "class" => "form-control form-control-user",
            ])
            ->add("username", TextType::class, [
                "unique" => true,
                "required" => true,
                "label" => "Username",
                "class" => "form-control form-control-user",
            ])
            ->add("firstname", TextType::class, [
                "label" => "Prénom",
                "class" => "form-control form-control-user",
            ])
            ->add("lastname", TextType::class, [
                "label" => "Nom",
                "class" => "form-control form-control-user",
            ])
            ->add("age", DateType::class, [
                "label" => "Age",
                "class" => "form-control form-control-user",
            ])
            ->add("description", TextAreaType::class, [
                "label" => "Description",
                "class" => "form-control form-control-user ckeditor",
            ])
            ->add(
                "password", PasswordType::class, [
                    'required' => false,
                    'label' => 'Mot de passe',
                    'placeholder' => 'Votre mot de passe',
                    "class" => "form-control form-control-user",
                ]
            )
            ->add(
                "password_confirmation", PasswordType::class, [
                    'required' => false,
                    'label' => 'Confirmation Mot de passe',
                    'placeholder' => '',
                    "class" => "form-control form-control-user",
                    "mapped" => false,
                ]
            )
            ->add("submit", SubmitType::class, [
                "label" => "Valider",
                "class" => "btn btn-primary"
            ])
            ;
    }

    public function getBlockPrefix()
    {
        return "app_user";
    }

    public function getOptions(): array
    {
        return [
            "data_class" => User::class
        ];
    }
}