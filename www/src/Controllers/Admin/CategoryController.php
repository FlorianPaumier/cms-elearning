<?php


namespace App\Controllers\Admin;


use App\Core\Cache\ConfigHandler;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Commentary;
use App\Form\ArticleForm;
use App\Form\CategoryForm;
use App\Repository\CategoryRepository;
use Exception;

class CategoryController extends BaseController
{

    public function index(CategoryRepository $repository)
    {
        $category = $repository->paginate(5);

        return $this->renderer->render("admin/category/index",[
            "categories" => $category,
            "title" => "Liste d'articles"
        ]);
    }

    public function list(ArticleRepository $repository)
    {
        $articles = $repository->paginate(5);

        return $this->renderer->render("admin/category/category_list",[
            "category" => $articles,
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
        $article = new Category();

        $form = $this->createForm(CategoryForm::class, $article);
        $form->handleRequest($request);

        if($request->getMethod() == "POST" && $form->isValid()) {
            $em = ConfigHandler::get("entityManager");
            $em->persist($article)->flush();
            $this->redirect->redirectToRoute("admin_category");
        }

        return $this->renderer->render("admin/category/new",[
            "title" => "Création de catégorie",
            "form" => $form->createView(),
            "errors"=> $form->getErrorFeedback()
        ]);
    }

    public function edit(Request $request, CategoryRepository $repository, Category $category)
    {
        $lesson = $repository
            ->where("category.id = :id")
            ->setParameter("id", $category->getId())
            ->fetch();

        $form = $this->createForm(ArticleForm::class, $article);
        $form->handleRequest($request);

        if ($request->getMethod() == "POST" && $form->isValid()) {
            $em = ConfigHandler::get("entityManager");
            $em->persist($article);
            $em->flush();
            $this->redirect->redirectToRoute("admin_article_list");
        }

        return $this->renderer->render("admin/articles/new", [
            "form" => $form->createView(),
            "title" => "Modification de l'article"
        ]);
    }

    public function delete(Request $request, Article $article)
    {
        $this->redirect->redirectToRoute("admin_article_index");
    }


    public function design()
    {
        return $this->renderer->render("admin/article/article_design",[
            "title" => "Design d'article"
        ]);
    }
}