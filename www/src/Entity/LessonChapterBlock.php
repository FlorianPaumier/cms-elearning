<?php


namespace App\Entity;


use App\Core\Interfaces\Entity;

class LessonChapterBlock
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
     * @return LessonChapterBlock
     */
    public function setIdChapter(int $idChapter): LessonChapterBlock
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
     * @return LessonChapterBlock
     */
    public function setTitle(string $title): LessonChapterBlock
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
     * @return LessonChapterBlock
     */
    public function setContent(string $content): LessonChapterBlock
    {
        $this->content = $content;
        return $this;
    }
}