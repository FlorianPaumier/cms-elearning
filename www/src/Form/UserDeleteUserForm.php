<?php

namespace App\Form;

use App\Core\Cache\ConfigHandler;
use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\ButtonType;
use App\Core\Form\Fields\TextType;
use App\Core\Form\FormBuilder;
use App\Entity\User;

class UserDeleteUserForm extends AbstractForm
{

    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder
            ->setAction(ConfigHandler::get("router")->getPath("app_user_delete_user"))
            ->add(
                "email", TextType::class, [
                    'type' => 'email',
                    'required' => true,
                    'label' => 'Email',
                    "class" => "form-control form-control-user",
                    "before" => "<i class=\"fa fa-user\"></i>",
                ]

            )
            ->add(
                "submit", ButtonType::class, [
                    'type' => 'submit',
                    'label' => "Valider",
                    "class" => "btn",
                ]
            );
    }
/**
 * @inheritDoc
 */
    public function getBlockPrefix(): string
    {
        return "app_delete_user";
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
