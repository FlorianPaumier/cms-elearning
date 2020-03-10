<?php

namespace App\Form;

<<<<<<< HEAD
=======

use App\Core\Cache\ConfigHandler;
use App\Core\Form\FormBuilder;
>>>>>>> e881ede0f36dd95b53201673b4a386a88f13c4c6
use App\Core\Form\FormType;
use App\Core\Interfaces\FormTypeInterface;
use App\Core\Kernel\Kernel;

class UserLoginForm extends FormBuilder implements FormTypeInterface
{
    /**
     * @return array|void
     */
<<<<<<< HEAD
    public static function getConstraint() /** Pour permettre la validation du formulaire */
=======
    public static function getConstraint(): array
>>>>>>> e881ede0f36dd95b53201673b4a386a88f13c4c6
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

<<<<<<< HEAD
    /** Pour créer nos inputs form
     * chaque input a une clé pour pouvoir savoir dire c'est quoi dans notre entité
     */
    public function buildForm()
    {
        $this->formBuilder
            ->setAction(Kernel::get("router")->getPath("app_user_login_check")) // fonction non obligatoire, permettant de donné une url différente à l'url actuelle du formulaire
=======
    public function buildForm(): FormBuilder
    {
        $this
            ->setAction(ConfigHandler::get("router")->getPath("app_user_login_check"))
>>>>>>> e881ede0f36dd95b53201673b4a386a88f13c4c6
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
<<<<<<< HEAD
                    "before" => "<i class=\"fa fa-key\"></i>",
                ]
            )
            ->checkbox(
                "remember_me", [
                    'required' => true,
                    'label' => 'Ce souvenir de moi',
                    "type" => "checkbox",
                    "class" => "col-1",
=======
                    "before" => "<i class=\"fa fa-key\"></i>"
                ]
            )
            ->checkbox(
                "remember_me",  [
                    'required' => true,
                    'label' => 'Ce souvenir de moi',
                    "type" => "checkbox",
                    "class" => "col-1"
>>>>>>> e881ede0f36dd95b53201673b4a386a88f13c4c6
                ]
            )
            ->button(
                "submit", [
                    'label' => "Se connecter",
                    "type" => "submit",
<<<<<<< HEAD
                    "class" => "state",
                    "after" => "<i class=\"spinner\"></i>",
=======
                    "class" => "btn btn-primary"
>>>>>>> e881ede0f36dd95b53201673b4a386a88f13c4c6
                ]
            );

        return $this;
    }

<<<<<<< HEAD
    public function getBlockPrefix() /** Pour permettre la récuperation du données du formulaire avec les préfixes */
=======
    public function getBlockPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * @inheritDoc
     */
    public function setBlockPrefix(): void
>>>>>>> e881ede0f36dd95b53201673b4a386a88f13c4c6
    {
        $this->prefix = "app_user";
    }
}
