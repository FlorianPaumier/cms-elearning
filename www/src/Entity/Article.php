<?php


namespace App\Entity;


use App\Core\Interfaces\Entity;

class Article
{

    use Entity;

    /** @var string */
    protected $title;

    /** @var string */
    protected $content;

    /** @var int */
    protected $category;

    /** @var string */
    protected $image;

    /** @var string */
    protected $creationDate;

    /** @var string */
    protected $editDate;

    /**
     * @param string $title
     * @return string
     */
    public function setTitle(string $title): string
    {
        $this->title = $title;

        return $this->title;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return string
     */
    public function setContent(string $content): string
    {
        $this->content = $content;

        return $this->content;
    }

    public function getCategory(): int
    {
        return $this->category;
    }

    public function setCategory(int $category): int
    {
        $this->category;

        return $this->category;
    }

    public function getImage(): int
    {
        return $this->image;
    }

    public function setImage(string $image): int
    {
        $this->image = $image;

        return $this->image;
    }

    public function getCreationDate(): string
    {
        return $this->creationDate;
    }

    public function setEditDate(string $editDate): string
    {
        $this->editDate = $editDate;

        return $this->editDate;
    }

    public function getEditDate(string $editDate): string
    {
        return $this->editDate;

    }
}