<?php
namespace Controllers\Users;

use App\Core\Interfaces\BaseController;
use App\Form\UserLoginForm;
use App\Form\UserRegisterForm;

class UserController extends BaseController
{

    public function login()
    {
        if ($this->userManager->isConnected()) {
            (new RedirectionHandler())
                ->redirectToRoute("app_home");
        }

        $form = $this->form->buildForm(UserLoginForm::class);
    }

    public function register()
    {
        if ($this->userManager->isConnected()) {
            (new RedirectionHandler())
                ->redirectToRoute("app_home");
        }

        $form = $this->form->buildForm(UserRegisterForm::class);
    }

    public function logout()
    {
        $this->userManager->disconnectUser();
        $this->redirect->redirectToRoute("app_home");
    }

    public function forgotpassword()
    {
        $this->renderer->render("security/forget_password");
    }
}
