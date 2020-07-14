<?php


namespace App\Entity;


use App\Core\Interfaces\Entity;
use App\Core\Helpers\TimestampableEntity;

class Article
{

    use Entity;
    use TimestampableEntity;

    /** @var string */
    protected $title;

    /** @var string */
    protected $content;

    /** @var int */
    protected $idCategory;

    /** @var string */
    protected $image;

    /** @var string */
    protected $createDate;

    /** @var string */
    protected $editDate;

    /** @var int */
    protected $idUser;

    /** @var int */
    protected $visible;

    /**
     * @return int
     */
    public function getVisible(): ?int
    {
        return $this->visible;
    }

    /**
     * @param int $visible
     */
    public function setVisible(?int $visible): void
    {
        $this->visible = $visible;
    }

    /**
     * @return int
     */
    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    /**
     * @param int $idUser
     */
    public function setIdUser(?int $idUser): void
    {
        $this->idUser = $idUser;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    public function getIdCategory(): ?int
    {
        return $this->idCategory;
    }

    public function setIdCategory(?int $idCategory): void
    {
        $this->idCategory = $idCategory;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function getCreateDate(): ?string
    {
        return $this->createDate;
    }

    public function setCreateDate(?string $createDate): void
    {
        $this->createDate = $createDate;
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