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

    /**
     * @param string|null $commentary
     */
    public function setCommentary(?string $commentary): void
    {
        $this->commentary = $commentary;
    }

    /**
     * @return string|null
     */
    public function getCommentary(): ?string
    {
        return $this->commentary;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param Article|null $article
     */
    public function setArticle(?Article $article): void
    {
        $this->article = $article;
    }

    /**
     * @return Article|null
     */
    public function getArticle(): ?Article
    {
        return $this->article;
    }
}