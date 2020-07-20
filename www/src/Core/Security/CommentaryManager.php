<?php

namespace App\Core\Security;

use App\Core\database\Hydrator;
use App\Core\Database\QueryBuilder;
use App\Core\Database\EntityManager;
use App\Entity\User;
use App\Core\Request\Request;
use App\Core\Session\PHPSession;
use App\Core\Kernel\Kernel;

class CommentaryManager
{
    /**
     * @var QueryBuilder
     */
    private $entityManager;

    /**
     * @var PHPSession
     */
    private $article;

    private $security;

    public function __construct()
    {
        $this->entityManager = Kernel::get("entityManager");
        $this->session  = Kernel::get("article");
        $this->security  = Kernel::get("security");
    }

    /**
     * Logout the current user
     */
    public function deleteCommentary()
    {
    }


    public function getCommentary()
    {
//        $article = $this->article->offsetGet('app.article');
//        $commentary = $this->entityManager->form('commentary')->findBy(['id_article' => $article["id_article"]] );
//        return $this->entityManager->hydrate(new Commentary(), $commentary);
    }

    public function updateCommentary()
    {

    }

    /**
     * Create a new user
     */
    public function createCommentary(Request $query)
    {
        $user = Hydrator::hydrate($query->getRequest()->all(), User::class);

        $value = $user->objectToSql();

        $error = [];

        if($this->entityManager->from("user")->findBy(["email" => $value["email"]])){
            return "Votre email exist déjà. Veuillez le modifier";
        }

        if($this->entityManager->persist($value)){
            return true;
        }

        return "Une erreur estr survenue. Veuilliez réessayer. Si l'erreur persist contacter l'admin";
    }

    /**
     * Send a new password to the email if exists
     */
    public function forgetPassword(string $email)
    {
    }
}