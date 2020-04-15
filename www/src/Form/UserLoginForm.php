<?php

namespace App\Form;


use App\Core\Cache\ConfigHandler;
use App\Core\form\Fields\TextType;
use App\Core\Form\FormBuilder;
use App\Core\Form\FormType;
use App\Core\Interfaces\FormTypeInterface;
use App\Core\Kernel\Kernel;

class UserLoginForm implements FormTypeInterface
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

    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder
            ->setAction(ConfigHandler::get("router")->getPath("app_user_login_check"))
            ->add(
                "username",TextType::class, [
                    'type' => 'text',
                    'required' => true,
                    'label' => 'Username',
                    "class" => "form-control form-control-user"
                ]
            );
    }

    /**
     * @inheritDoc
     */
    public function getBlockPrefix(): string
    {
        return $this->prefix = "app_user";
    }
}