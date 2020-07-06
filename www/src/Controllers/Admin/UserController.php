<?php


namespace App\Controllers\Admin;


use App\Core\Cache\ConfigHandler;
use App\Core\Database\Hydrator;
use App\Core\Database\Table;
use App\Core\Database\EntityManager;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\Lesson;
use App\Entity\User;
use App\Form\AdminUserForm;
use App\Repository\UserRepository;

class UserController extends BaseController
{

    public function indexUser(UserRepository $repository)
    {
        $users = $repository->paginate(5);

        return $this->renderer->render("admin/users/user", [
            "users" => $users,
            'title' => "Listes des utilisateurs"
        ]);
    }

    public function newUser(Request $request)
    {
        $user = new user();
        $form = $this->createForm(AdminUserForm::class, $user);
        $form->handleRequest($request);

        if ($this->query->getMethod() == "POST") {

            if ($form->isValid()) {
                $password = $user->getPassword();
                $user->setPassword(md5($password));


                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $this->redirect->redirectToRoute("admin_user_list");
            } else {
                $this->session->set("app.flash", ["error" => $form->getErrors()]);
            }
        }

        return $this->renderer->render("admin/users/new", [
            "form" => $form->createView(),
            "errors" => $form->getErrorFeedback(),
            'title' => "Création d'un Utilisateur"
        ]);
    }

    public function edit(Request $request, Lesson $lesson)
    {
        $chapters = $this->repository
            ->from("lesson_chapter", "lc")
            ->select("id","title")
            ->join("INNER JOIN", "lesson on lc.lesson_id = lesson.id")
            ->where("lesson.id = :id")
            ->setParam("id", $lesson->getId())
            ->fetchOrFail();

        foreach ($chapters as $chapter){
            $lesson->addChapters(Hydrator::hydrate($chapter, LessonChapter::class));
        }

        $form = $this->createForm(LessonForm::class, $lesson);
        $form->handleRequest($request);

        if ($request->getMethod() == "POST" && $form->isValid()) {
            $em = ConfigHandler::get("repository");
            $em->persist($lesson);
            $em->flush();
            $this->redirect->redirectToRoute("admin_lesson_list");
        }


        return $this->renderer->render("admin/lessons/new", [
            "form" => $form->createView(),
            'title' => "Création d'un Cour"
        ]);
    }



    public function deleteUser(Request $request, User $user){

        $this->entityManager->delete($user);

        $this->redirect->redirectToRoute("admin_user_list");
    }
}