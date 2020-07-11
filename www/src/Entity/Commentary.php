<?php


namespace App\Entity;

use App\Core\Interfaces\Entity;

class Commentary
{
    use Entity;

    /** @var string */
    protected $commentary;

    /** @var int */
    protected $idUser;

    /** @var int */
    protected $idArticle;

    /** @var string */
    protected $createDate;

    /** @var string */
    protected $editDate;

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

    public function setCreateDate(?string $createDate): void
    {
        $this->createDate = $createDate;
    }

    public function getCreateDate(): ?string
    {
        return $this->createDate;
    }

    public function setEditDate(?string $editDate): void
    {
        $this->editDate = $editDate;
    }

    public function getEditDate(): ?string
    {
        return $this->editDate;
    }
}