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

    /** @var int */
    protected $id_user;

    /** @var int */
    protected $id_article;

    public function __construct()
    {
        $this->id_user = 1;
    }

    public function setCommentary(?string $commentary): void
    {
        $this->commentary = $commentary;
    }

    public function getCommentary(): ?string
    {
        return $this->commentary;
    }

    public function getIdUser(): ?int
    {
        return $this->id_user;
    }

    public function setIdArticle(?int $idArticle): void
    {
        $this->id_article = $id_article;
    }

    public function getIdArticle(): ?int
    {
        return $this->id_article;
    }
}