<?php


namespace App\Entity;


use App\Core\Interfaces\Entity;

class LessonChapterBlock
{

    use Entity;

    /** @var LessonChapter */
    protected $chapter;

    /** @var string */
    protected $title;

    /** @var string */
    protected $content;

    /**
     * @return LessonChapter
     */
    public function getChapter(): LessonChapter
    {
        return $this->chapter;
    }

    /**
     * @param LessonChapter $chapter
     * @return LessonChapterBlock
     */
    public function setChapter(LessonChapter $chapter): LessonChapterBlock
    {
        $this->chapter = $chapter;
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