<?php

namespace App\Form;

use App\Core\Cache\ConfigHandler;
use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\ButtonType;
use App\Core\Form\Fields\PasswordType;
use App\Core\Form\Fields\TextType;
use App\Core\Form\FormBuilder;
use App\Entity\User;

class UserRegisterForm extends AbstractForm
{

    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder
            ->setAction(ConfigHandler::get("router")->getPath("app_user_login_check"))
            ->add(
                "username", TextType::class, [
                    'type' => 'text',
                    'required' => true,
                    'label' => 'Username',
                    "class" => "form-control form-control-user",
                    "before" => "<i class=\"fa fa-user\"></i>",
                ]
            )
            ->add(
                "password", PasswordType::class, [
                    'required' => false,
                    'label' => 'Mot de passe',
                    "class" => "form-control form-control-user",
                ]
            )
            ->add(
                "password_confirmation", PasswordType::class, [
                    'required' => false,
                    'label' => 'Mot de passe',
                    "class" => "form-control form-control-user",
                    "mapped" => false,
                ]
            )
            ->add(
                "submit", ButtonType::class, [
                    'type' => 'submit',
                    'label' => "S'inscrire",
                    "class" => "btn",
                ]
            );
    }
/**
 * @inheritDoc
 */
    public function getBlockPrefix(): string
    {
        return "app_user";
    }

    /**
     * @inheritDoc
     */
    public function configureOptions()
    {
        $this->options = [
            "data_class" => User::class,
        ];
    }
}
