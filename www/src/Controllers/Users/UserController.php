<?php

namespace App\Controllers\Users;

use App\Core\Cache\ConfigHandler;
use App\Core\Evaluation\EvaluationObject;
use App\Core\Interfaces\BaseController;
use App\Core\Request\RedirectionHandler;
use App\Core\Request\Request;
use App\Entity\User;
use App\Entity\UserLesson;
use App\Form\UserDeleteUserForm;
use App\Form\UserEditForm;
use App\Form\UserForgetpasswordForm;
use App\Form\UserLoginForm;
use App\Form\UserRegisterForm;
use App\Repository\EvaluationObjectRepository;
use App\Repository\LessonRepository;
use App\Repository\StreamInscriptionRepository;
use App\Repository\UserLessonRepository;
use App\Repository\UserRepository;

class UserController extends BaseController
{

    /**
     * @param Request $request
     * @return \App\Core\Render\RenderView|string|string[]|null
     * @throws \Exception
     *
     * verifie si user connecté et redirige vers la home
     */
    public function login(Request $request)
    {
        if ($this->userManager->isConnected()) {
            (new RedirectionHandler())
                ->redirectToRoute("app_home");
        }


        $user = new User();
        $form = $this->createForm(UserLoginForm::class, $user);


        return $this->renderer->render(
            ROOT_PATH . "/public/views/security/frontend/login",
            [
                "form" => $form->createView(),
                "errors" => [],
            ]
        );
    }

    /**
     * @param Request $request
     * @return \App\Core\Render\RenderView|string|string[]|null
     * @throws \Exception
     *
     */
    public function register(Request $request)
    {
        $user = new user();
        $form = $this->createForm(UserRegisterForm::class, $user);
        $form->handleRequest($request);



            if ($form->isValid()) {
                $password = $user->getPassword();
                $user->setPassword(password_hash($password, PASSWORD_BCRYPT));
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                if (($response = $this->userManager->confirmRegister($user->getEmail())) !== true) {

                    $this->session->offsetSet("app.flash", ["error" => [$response]]);


                }

                $this->redirect->redirectToRoute("app_user_login");
            } else {
                $this->session->offsetSet("app.flash", ["error" => $form->getErrorFeedback()]);
            }

        return $this->renderer->render(
            ROOT_PATH . "/public/views/security/frontend/register",
            [
                "form" => $form->createView(),
            ]
        );
    }

    /**
     * @param Request $request
     * @throws \Exception
     */
    public function loginCheck(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserLoginForm::class, $user);
        $form->handleRequest($request);

        if ($this->query->getMethod() == "POST" && $form->isValid()) {
            if (($response = $this->userManager->connectUser($user->getUsername(), $user->getPassword())) !== true) {
                $this->session->offsetSet("app.flash", ["error" => [$response]]);
            } else {
                $this->redirect->redirectToRoute("app_home");
            }
        }

        ConfigHandler::get('session')->offsetSet("app.flash", ["error" => $form->getErrorFeedback()]);

        $this->redirect->redirectToRoute("app_user_login");
    }

    /**
     * @throws \Exception
     */
    public function logout()
    {
        $this->userManager->disconnectUser();
        $this->redirect->redirectToRoute("app_home");
    }

    /**
     * @param Request $request
     * @return \App\Core\Render\RenderView|string|string[]|null
     * @throws \Exception
     */
    public function forgetPassword(Request $request)
    {
        $form = $this->createForm(UserForgetpasswordForm::class);
        $form->handleRequest($request);

        if ($this->query->getMethod() == "POST" && $form->isValid()) {
                $email = $form->get("email");
                if (($response = $this->userManager->forgetPassword($email)) !== true) {
                    $this->session->offsetSet("app.flash", ["error" => [$response]]);
                } else {
                    $this->redirect->redirectToRoute("app_home");
                }

        }

        return $this->renderer->render(
            "security/frontend/forget_password",
            [
                "form" => $form->createView(),
            ]
        );
    }

    public function confirmationAccount(Request $request, UserRepository $userRepository)
    {
        $token = $request->getQuery()->get("token");

        if(is_null($token)){
            $this->redirect->redirectToRoute("app_home");
        }

        /** @var User $user */
        $user = $userRepository->findOneBy(["confirmation_token" => $token]);

        if (is_null($user) || is_array($user))
            $this->redirect->redirectToRoute("app_home");

        $user->setStatus(true);
        $this->entityManager->persist($user)->flush();

        $this->redirect->redirectToRoute("app_home");

    }


    public function resetPassword(Request $request, UserRepository $userRepository)
    {
        $user = new user();
        $form = $this->createForm(UserResetPasswordForm::class, $user);
        $form->handleRequest($request);

        $token = $request->getQuery()->get("token");

        if(is_null($token)){
            $this->redirect->redirectToRoute("app_home");
        }

        /** @var User $user */
        $user = $userRepository->findOneBy(["confirmation_token" => $token]);

        if (is_null($user) || is_array($user))
            $this->redirect->redirectToRoute("app_home");

        $password = $user->getPassword();
        $user->setPassword(password_hash($password, PASSWORD_BCRYPT));
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->redirect->redirectToRoute("app_home");

    }

    /**
     * @param Request $request
     * @throws \Exception
     */
    public function deleteUser(Request $request)
    {
        $currentUser = $this->getUser();

        if(empty($currentUser)) $this->redirect->redirectToRoute('app_user_login');

        $user = $this->entityManager->setEntity(User::class)->findBy(["email" => $currentUser["user"]]);

        if($this->entityManager->delete($user)) {
            $this->session->offsetUnset("app.user");
        }else{
            $this->redirect->redirectToRoute("app_user_profile");
        }
            $this->redirect->redirectToRoute("app_home");
        }

    /**
     * Show user profile
     * @param Request $request
     * @param StreamInscriptionRepository $repository
     * @return \App\Core\Render\RenderView|string|string[]|null
     * @throws \App\Core\Exception\NoRecordException
     */
    public function profile(Request $request, StreamInscriptionRepository $repository)
    {
        $events = $repository->findBy(["user_id" => $this->getUser()->getId()]);
        return $this->render("user/profile", [
            "user" => $this->getUser(),
            "events" => is_array($events) > 1 ?: [$events],
        ]);
    }

    /**
     * Edition of some informations of the user profile
     * @param Request $request
     * @return \App\Core\Render\RenderView|string|string[]|null
     * @throws \Exception
     */
    public function edit(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(UserEditForm::class, $user);
        $form->handleRequest($request);

        if ($form->isValid()){
            $this->entityManager->persist($user)->flush();
            $this->redirect->redirectToRoute("app_user_update");
        }

        return $this->render("user/edit", [
            "form" => $form->createView(),
            "errors" => $form->getErrorFeedback(),
            "user" => $user,
        ]);
    }

    /**
     * Show all the lessons start by the user
     * @param Request $request
     * @param UserLessonRepository $userLessonRepository
     * @param EvaluationObjectRepository $evaluationObjectRepository
     * @param LessonRepository $lessonRepository
     * @return \App\Core\Render\RenderView|string|string[]|null
     * @throws \Exception
     */
    public function lessons(Request $request, UserLessonRepository $userLessonRepository, EvaluationObjectRepository $evaluationObjectRepository, LessonRepository $lessonRepository)
    {
        $user = $this->getUser();
        /** @var UserLesson[] $lessons */
        $lessons = $userLessonRepository
            ->where("user_id = :id")
            ->orderBy("lesson_id", "ASC")
            ->setParameter("id", $user->getId())
            ->fetch();

        /** @var EvaluationObject[] $evaluation */
        $evaluations = $evaluationObjectRepository->where("user_id = :id")->setParameter("id", $user->getId())->fetch();

        if (!is_array($evaluations)) $evaluations = [$evaluations];
        if (!is_array($lessons)) $lessons = [$lessons];

        foreach ($evaluations as $evaluation){
            $evaluation->getEvaluation()->setLesson($lessonRepository->find($evaluation->getEvaluation()->getLesson()->getId()));
        }

        $cours = [];
        foreach ($lessons as $lesson){
            $id = $lesson->getLesson()->getId();

            $cours[$id]["title"] = $lesson->getLesson()->getTitle();
            if($lesson->getChapter() == 0){
                $cours[$id]["start"] = $lesson->getCreatedAt()->format("d-m-Y");
            }

            $cours[$id]["over"] = $lesson->getIsOver() ? "Oui" : "Non";

            if($cours[$id]["chapter"] < $lesson->getChapter()){
                $cours[$id]["chapter"] = $lesson->getChapter();
            }
        }

        return $this->render("user/lessons", [
            "lessons" => $cours,
            "evaluations" => $evaluations,
            "user" => $user,
        ]);
    }
}