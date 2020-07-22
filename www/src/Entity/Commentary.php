<?php


namespace App\Entity;

use App\Core\Helpers\TimestampableEntity;
use App\Core\Interfaces\Entity;

class Commentary
{
    use Entity;
    use TimestampableEntity;

    /** @var string */
    protected $commentary;

    /** @var User */
    protected $user;

    /** @var Article */
    protected $article;

    public function __construct()
    {
        $this->user = 1;
    }

    public function setCommentary(?string $commentary): void
    {
        $this->commentary = $commentary;
    }

    public function getCommentary(): ?string
    {
        return $this->commentary;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setArticle(?Article $article): void
    {
        $this->article = $article;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }
}