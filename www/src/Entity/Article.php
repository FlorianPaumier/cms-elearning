<?php


namespace App\Entity;


use App\Core\Interfaces\Entity;
use App\Core\Helpers\TimestampableEntity;

class Article
{

    use Entity;
    use TimestampableEntity;

    /** @var string $title*/
    protected $title;

    /** @var null|string $content*/
    protected $content;

    /** @var null|Category $category */
    protected $category;

    /** @var null|string $image*/
    protected $image;

    /** @var null|User $user*/
    protected $user;

    /** @var null|bool $visible*/
    protected $visible;

    /**
     * @return bool
     */
    public function getVisible(): ?bool
    {
        return $this->visible;
    }

    /**
     * @param bool $visible
     */
    public function setVisible(?bool $visible): void
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
    public function setUser(?User $user)
    {
        $this->user = $user;
    }

    /**
     * @param string $title
     */
    public function setTitle(?string $title): void
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
     * @return null|string
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

    /**
     * @param Category $category
     */
    public function setCategory(?Category $category): void
    {
        $this->category = $category;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     */
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }
}