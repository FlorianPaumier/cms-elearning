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
}