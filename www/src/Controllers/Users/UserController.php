<?php
namespace App\Controllers\Users;

use App\Core\Interfaces\BaseController;
use App\Core\Request\RedirectionHandler;
use App\Core\Request\Request;
use App\Entity\User;
use App\Form\UserDeleteUserForm;
use App\Form\UserForgetpasswordForm;
use App\Form\UserLoginForm;
use App\Form\UserRegisterForm;

class UserController extends BaseController
{

    public function login(Request $request)
    {
        if ($this->userManager->isConnected()) {
            (new RedirectionHandler())
                ->redirectToRoute("app_home");
        }
        $user = new User();
        $form = $this->createForm(UserLoginForm::class, $user);
        $form->handleRequest($request);
        
        if ($this->query->getMethod() == "POST" && $form->isValid()) {
            
            if (($response = $this->userManager->connectUser($user->getUsername(), $user->getPassword)) !== true) {
                $this->session->set("app.flash", ["error" => [$response]]);
            }  else {
                $this->redirect->redirectToRoute("app_home");
            }

            
        }

        return $this->renderer->render(
            "security/login", [
                "form" => $form->createView(),
                "errors" => [],
            ]
        );
    }

    public function register(Request $request)
    {
        /*if($this->userManager->isConnected()){
        $this->redirect->redirectToRoute("app_home");
        }*/
        $user = new user();
        $form = $this->createForm(UserRegisterForm::class, $user);
        $form->handleRequest($request);

        if ($this->query->getMethod() == "POST") {

            if ($form->isValid()) {
                $password = $user->getPassword();
                $user->setPassword(md5($password));
                $this->repository->persist($user);
                $this->repository->flush();

                $this->redirect->redirectToRoute("app_user_login");

            } else {
                $this->session->set("app.flash", ["error" => $form->getErrors()]);
            }
        }

        return $this->renderer->render(
            ROOT_PATH . "/public/views/security/frontend/register", [
                "form" => $form->createView(),
            ]
        );

    }

    public function loginCheck(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserLoginForm::class, $user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            if ($this->userManager->connectUser($this->query->getRequest()->get("username"), $this->query->getRequest()->get("password"))) {
                $this->redirect->redirectToRoute("app_home");
            } else {
                $this->session->set("app.flash", ["error" => ["Votre username ou votre mot de passe est incorrect"]]);
            }
        } else {
            $this->session->set("app.flash", ["error" => $form->getErrorFeedback()]);
        }

        $this->redirect->redirectToRoute("app_user_login");
    }

    public function logout()
    {
        $this->userManager->disconnectUser();
        $this->redirect->redirectToRoute("app_home");
    }

    public function forgetPassword(Request $request)
    {
        $form = $this->createForm(UserForgetpasswordForm::class);
        $form->handleRequest($request);

        if ($this->query->getMethod() == "POST") {

            if ($form->isValid()) {
                $email = "";
                if (($response = $this->userManager->forgetPassword($email)) !== true) {
                    $this->session->set("app.flash", ["error" => [$response]]);
                } else {
                    $this->redirect->redirectToRoute("app_home");
                }
            } else {
                $this->session->set("app.flash", ["error" => $form->getErrors()]);
            }
        }

        return $this->renderer->render(
            "security/frontend/forget_password", [
                "form" => $form->createView(),
            ]
        );

    }

    public function deleteUser(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserDeleteUserForm::class, $user);
        $form->handleRequest($request);

        if ($this->query->getMethod() == "POST") {

            if ($form->isValid()) {
                $this->repository->delete($user);
                $this->repository->flush();
                $email = "";
                if (($response = $this->userManager->deleteUser($email)) !== true) {
                    $this->session->set("app.flash", ["error" => [$response]]);
                } else {
                    $this->redirect->redirectToRoute("app_home");
                }
            } else {
                $this->session->set("app.flash", ["error" => $form->getErrors()]);
            }
        }

        return $this->renderer->render(
            "security/frontend/delete_user", [
                "form" => $form->createView(),
            ]
        );

    }
}
