<?php


namespace App\Entity;


use App\Core\Interfaces\Entity;

class ChapterBlock
{

    use Entity;

    /** @var int */
    protected $idChapter;

    /** @var string */
    protected $title;

    /** @var string */
    protected $content;

    /**
     * @return int
     */
    public function getIdChapter(): int
    {
        return $this->idChapter;
    }

    /**
     * @param int $idChapter
     * @return ChapterBlock
     */
    public function setIdChapter(int $idChapter): ChapterBlock
    {
        $this->idChapter = $idChapter;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return ChapterBlock
     */
    public function setTitle(string $title): ChapterBlock
    {
        $this->title = $title;
        return $this;
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
     * @return ChapterBlock
     */
    public function setContent(string $content): ChapterBlock
    {
        $this->content = $content;
        return $this;
    }
}