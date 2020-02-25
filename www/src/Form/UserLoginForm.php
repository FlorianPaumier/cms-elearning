<?php

namespace App\Form;


use App\Core\Cache\ConfigHandler;
use App\Core\Form\FormBuilder;
use App\Core\Form\FormType;
use App\Core\Interfaces\FormTypeInterface;
use App\Core\Kernel\Kernel;

class UserLoginForm extends FormBuilder implements FormTypeInterface
{
    /**
     * @return array|void
     */
    public static function getConstraint(): array
    {
        return [
            [
                "username" => [
                    "empty" => false,
                    "required" => true,
                    "exists" => true,
                ]
            ],
            [
                "password" => [
                    "empty" => false,
                    "required" => true,
                    "exists" => true,
                ]
            ]
        ];
    }

    public function buildForm(): FormBuilder
    {
        $this
            ->setAction(ConfigHandler::get("router")->getPath("app_user_login_check"))
            ->input(
                "username", [
                    'type' => 'text',
                    'required' => true,
                    'label' => 'Username',
                    "class" => "form-control form-control-user"
                ]
            )
            ->input(
                "password",  [
                    'type' => 'password',
                    'required' => true,
                    'label' => 'Password',
                    "class" => "form-control form-control-user",
                    "before" => "<i class=\"fa fa-key\"></i>"
                ]
            )
            ->checkbox(
                "remember_me",  [
                    'required' => true,
                    'label' => 'Ce souvenir de moi',
                    "type" => "checkbox",
                    "class" => "col-1"
                ]
            )
            ->button(
                "submit", [
                    'label' => "Se connecter",
                    "type" => "submit",
                    "class" => "btn btn-primary"
                ]
            );

        return $this;
    }

    public function getBlockPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * @inheritDoc
     */
    public function setBlockPrefix(): void
    {
        $this->prefix = "app_user";
    }
}