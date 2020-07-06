<?php


namespace App\Controllers\Admin;


use App\Core\Cache\ConfigHandler;
use App\Core\Database\Hydrator;
use App\Core\Database\Table;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\User;
use App\Form\UserDeleteUserForm;

class UserController extends BaseController
{

    public function indexUser()
    {
        $this->repository->getClass(User::class);
        $users = $this->repository->findAll();

        return $this->renderer->render("admin/users/user", [
            "Users" => $users,
            'title' => "Listes des utilisateurs"
        ]);
    }

    public function new(Request $request)
    {
        $lesson = new Lesson();

        $form = $this->createForm(LessonForm::class, $lesson);
        $form->handleRequest($request);

        if ($request->getMethod() == "POST" && $form->isValid()) {
            /** @var Table $em */
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

    public function deleteUser(Request $request)
    {
        $currentUser = $this->getUser();

        if(empty($currentUser)) $this->redirect->redirectToRoute('admin_user_list');

        $user = $this->repository->setEntity(User::class)->findBy(["email" => $currentUser["user"]]);

        if($this->repository->from("user")->delete($user->getId())) {
            $this->session->offsetUnset("app.user");
        }


        $this->redirect->redirectToRoute("admin_user_list");

    }
}