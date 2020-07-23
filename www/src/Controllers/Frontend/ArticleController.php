<?php

namespace App\Controllers\Frontend;

use App\Core\Cache\ConfigHandler;
use App\Core\Exception\NoRecordException;
use App\Core\Interfaces\BaseController;
use App\Core\Render\RenderView;
use App\Core\Request\Request;
use App\Entity\Article;
use App\Entity\Commentary;
use App\Form\CommentaryForm;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\CommentaryRepository;
use Exception;

class ArticleController extends BaseController
{
    /**
     * display the list of article
     *
     * @param ArticleRepository $repository
     * @return RenderView|string|string[]|null
     * @throws Exception
     */
    public function index(ArticleRepository $repository)
    {
        $articles = $repository->where("visible = true")->paginate(5);

        return $this->renderer->render("frontend/article/index",[
            "articles" => $articles,
            "title" => "Liste d'articles"
        ]);
    }

    /**
     * display an article information and his commentary
     *
     * @param Request $request
     * @param ArticleRepository $repository
     * @param Article $article
     * @param CategoryRepository $category
     * @param CommentaryRepository $commentary
     * @return RenderView|string|string[]|null
     * @throws NoRecordException
     */
    public function view(Request $request, ArticleRepository $repository, Article $article, CategoryRepository $category, CommentaryRepository $commentary)
    {
        if(!$article->getVisible()){
            $this->redirect->redirectToRoute("article_list");
        }

        $comment = new Commentary();

        $commentForm = $this->createForm(CommentaryForm::class, $comment);
        $commentForm->handleRequest($request);

        if($commentForm->isValid()) {
            $em = ConfigHandler::get("entityManager");
            $comment->setUser($this->getUser());
            $em->persist($comment);
            $em->flush();
            $this->redirect->redirectToRoute("article_view", ['id' => $article->getId()]);
        }

        $comments = $commentary->findBy(['id_article' => $article->getId()]);
        $category = $category->findBy(['id' => $article->getIdCategory()]);

        return $this->renderer->render("frontend/article/view", [
            "commentaryForm" => $commentForm->createView(),
            "category" => $category,
            "commentary" => $comments,
            "article" => $article,
            "title" => "Modification de l'article"
        ]);
    }
}