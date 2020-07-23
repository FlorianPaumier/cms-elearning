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

    /**
     * display the list of category
     *
     * @param CategoryRepository $repository
     * @return \App\Core\Render\RenderView|string|string[]|null
     * @throws Exception
     */
    public function index(CategoryRepository $repository)
    {
        $categories = $repository->paginate(5);

        return $this->renderer->render("admin/category/index",[
            "categories" => $categories,
            "title" => "Liste des catégories"
        ]);
    }

    /**
     * display the list of category
     *
     * @param CategoryRepository $repository
     * @return \App\Core\Render\RenderView|string|string[]|null
     * @throws Exception
     */
    public function list(CategoryRepository $repository)
    {
        $categories = $repository->paginate(5);

        return $this->renderer->render("admin/category/index",[
            "categories" => $categories,
            "title" => "Liste des catégories"
        ]);
    }

    /**
     * display a form to create a new item and insert the data if exist
     *
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

    /**
     * display a form to edit an item and update the data if exist
     *
     * @param Request $request
     * @param CategoryRepository $repository
     * @param Category $categories
     * @return \App\Core\Render\RenderView|string|string[]|null
     * @throws \App\Core\Exception\NoRecordException
     */
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

    /**
     * delete an item
     *
     * @param Category $category
     * @throws Exception
     */
    public function delete(Category $category)
    {
        $this->entityManager->delete($category);
        $this->redirect->redirectToRoute("admin_category");
    }
}