<?php

namespace App\Controllers\Users;

use App\Core\Interfaces\BaseController;
use App\Form\UserLoginForm;
use App\Form\UserRegisterForm;

class  UserController extends BaseController
{

    public function login()
    {
        /*if($this->userManager->isConnected()){
            $this->redirect->redirectToRoute("app_home");
        }*/

        $form = (new UserLoginForm())->buildForm();
        $this->renderer->render(
            "/security/login", [
            "form" => $form->createView()
             ]
        );
    }

    public function register()
    {
        /*if($this->userManager->isConnected()){
            $this->redirect->redirectToRoute("app_home");
        }*/

        $form = (new UserRegisterForm())->buildForm();

        if ($this->query->getMethod() == "POST") {
            $validator = $this->getValidator()->buildValidator(UserRegisterForm::getConstraint());

            if ($validator->isValid()) {

                if (($response = $this->userManager->createUser($this->query)) !== true) {
                    $this->session->set("app.flash", ["error" => [$response]]);
                } else {
                    $this->redirect->redirectToRoute("app_user_login");
                }
            } else {
                $this->session->set("app.flash", ["error" => $validator->getErrors()]);
            }
        }

        $this->renderer->render(
            ROOT_DIR . "/public/views/security/register", [
            "form" => $this->form->createView(),
            ]
        );
    }

    public function loginCheck()
    {
        $validator = $this->getValidator()->buildValidator(UserLoginForm::getConstraint());

        if ($validator->isValid()) {
            if ($this->userManager->connectUser($this->query->getRequest()->get("username"), $this->query->getRequest()->get("password"))) {
                $this->redirect->redirectToRoute("app_home");
            }else{
                $this->session->set("app.flash", ["error" => ["Votre username ou votre mot de passe est incorrect"]]);
            }
        }else{
            $this->session->set("app.flash", ["error" => $validator->getErrors()]);
        }

        $this->redirect->redirectToRoute("app_user_login");
    }

    public function logout()
    {
        $this->userManager->disconnectUser();
        $this->redirect->redirectToRoute("app_home");
    }
}