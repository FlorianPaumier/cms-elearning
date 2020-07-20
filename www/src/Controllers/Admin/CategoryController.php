<?php


namespace App\Controllers\Admin;


use App\Core\Cache\ConfigHandler;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\Category;
use App\Form\CategoryForm;
use App\Repository\CategoryRepository;
use Exception;

class CategoryController extends BaseController
{

    public function index(CategoryRepository $repository)
    {
        $categories = $repository->paginate(5);

        return $this->renderer->render("admin/category/index",[
            "categories" => $categories,
            "title" => "Liste des catégories"
        ]);
    }

    public function list(CategoryRepository $repository)
    {
        $categories = $repository->paginate(5);

        return $this->renderer->render("admin/category/index",[
            "categories" => $categories,
            "title" => "Liste des catégories"
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function new(Request $request)
    {
        $category = new Category();

        $form = $this->createForm(CategoryForm::class, $category);
        $form->handleRequest($request);

        if($form->isValid()) {
            $em = ConfigHandler::get("entityManager");
            $em->persist($category)->flush();
            $this->redirect->redirectToRoute("admin_category");
        }

        return $this->renderer->render("admin/category/new",[
            "title" => "Création de catégorie",
            "form" => $form->createView(),
            "errors"=> $form->getErrorFeedback()
        ]);
    }

    public function edit(Request $request, CategoryRepository $repository, Category $categories)
    {
        $category = $repository->findBy(['id' => $categories->getId()]);

        $form = $this->createForm(CategoryForm::class, $category);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = ConfigHandler::get("entityManager");
            $em->persist($category);
            $em->flush();
            $this->redirect->redirectToRoute("admin_category");
        }

        return $this->renderer->render("admin/category/edit", [
            "form" => $form->createView(),
            "title" => "Modification de la catégorie"
        ]);
    }

    public function delete(Request $request, Category $category)
    {
        $this->entityManager->delete($category);
        $this->redirect->redirectToRoute("admin_category");
    }
}