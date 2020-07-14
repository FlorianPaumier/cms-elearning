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
    protected $idUser;

    /** @var int */
    protected $idArticle;


    public function setCommentary(?string $commentary): void
    {
        $this->commentary = $commentary;
    }

    public function getCommentary(): ?string
    {
        return $this->commentary;
    }

    public function setIdUser(?int $idUser): void
    {
        $this->idUser = $idUser;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdArticle(?int $idArticle): void
    {
        $this->idArticle = $idArticle;
    }

    public function getIdArticle(): ?int
    {
        return $this->idArticle;
    }
}