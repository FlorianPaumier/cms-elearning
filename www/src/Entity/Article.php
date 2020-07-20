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

    /** @var Category */
    protected $category;

    /** @var string */
    protected $image;

    /** @var User */
    protected $user;

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
    public function setVisible(?int $visible = 0): void
    {
        $this->visible = $visible;
    }

    /**
     * @return User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
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

    /**
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }
}