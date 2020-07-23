<?php

namespace App\Form;

use App\Core\Cache\ConfigHandler;
use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\ButtonType;
use App\Core\Form\Fields\PasswordType;
use App\Core\Form\Fields\TextType;
use App\Core\Form\FormBuilder;
use App\Entity\User;

class UserResetPasswordForm extends AbstractForm
{

    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder
            ->setAction(ConfigHandler::get("router")->getPath("app_user_reset-token"))
            ->add(
                "password", PasswordType::class, [
                    'required' => false,
                    'label' => 'Votre nouveau mot de passe',
                    'placeholder' => 'Votre mot de passe',
                    "confirmation" => true,
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
        return "app_reset-token";
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
