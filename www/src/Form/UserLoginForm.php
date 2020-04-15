<?php

namespace App\Form;

use App\Core\Cache\ConfigHandler;
use App\Core\Form\FormBuilder;
use App\Core\Interfaces\FormTypeInterface;
use App\Core\Kernel\Kernel;

class UserLoginForm extends FormBuilder implements FormTypeInterface
{
    /**
     * @return array|void
     */
    public static function getConstraint(): array /** Pour permettre la validation du formulaire */
    {
        return [
            [
                "username" => [
                    "empty" => false,
                    "required" => true,
                    "exists" => true,
                ],
            ],
            [
                "password" => [
                    "empty" => false,
                    "required" => true,
                    "exists" => true,
                ],
            ],
        ];
    }

    /** Pour créer nos inputs form
     * chaque input a une clé pour pouvoir savoir dire c'est quoi dans notre entité
     */
    public function buildForm(): FormBuilder
    {
       return $this
            ->setAction(ConfigHandler::get("router")->getPath("app_user_login_check")) // fonction non obligatoire, permettant de donné une url différente à l'url actuelle du formulaire
            ->input(
                "username", [
                    'type' => 'text',
                    'required' => true,
                    'label' => 'Username',
                    "class" => "form-control form-control-user",
                    "before" => "<i class=\"fa fa-user\"></i>",
                ]
            )
            ->input(
                "password", [
                    'type' => 'password',
                    'required' => true,
                    'label' => 'Password',
                    "class" => "form-control form-control-user",
                    "before" => "<i class=\"fa fa-key\"></i>",
                ]
            )
            ->checkbox(
                "remember_me", [
                    'required' => true,
                    'label' => 'Ce souvenir de moi',
                    "type" => "checkbox",
                    "class" => "col-1",
                ]
            )
            ->button(
                "submit", [
                    'label' => "Se connecter",
                    "type" => "submit",
                    "class" => "state",
                    "after" => "<i class=\"spinner\"></i>",
                ]
            );
    }

    public function getBlockPrefix(): string /** Pour permettre la récuperation du données du formulaire avec les préfixes */
    {
        $this->prefix = "app_user";
    }

    /**
     * @inheritDoc
     */
    public function setBlockPrefix(): void
    {
        // TODO: Implement setBlockPrefix() method.
    }
}
