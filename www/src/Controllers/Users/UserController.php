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
                $this->repository->persist($user);
                $this->repository->flush();
                
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


        if ($this->query->getMethod() == "POST" && $form->isValid()) {

            if (($response = $this->userManager->connectUser($user->getUsername(), $user->getPassword())) !== true) {
                $this->session->set("app.flash", ["error" => [$response]]);
            } else {
//                $this->redirect->redirectToRoute("app_home");
            }
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
        $form = $this->createForm(UserDeleteUserForm::class);
        $form->handleRequest($request);

        if ($this->query->getMethod() == "POST") {
            $validator = $this->getValidator(new UserDeleteUserForm())->buildValidator($request);

            if ($validator->isValid()) {
                $email = "";
                if (($response = $this->userManager->deleteUser($email)) !== true) {
                    $this->session->set("app.flash", ["error" => [$response]]);
                } else {
                    $this->redirect->redirectToRoute("app_home");
                }
            } else {
                $this->session->set("app.flash", ["error" => $validator->getErrors()]);
            }
        }

        return $this->renderer->render(
            "security/frontend/delete_user", [
                "form" => $form->createView(),
            ]
        );

    }
}
