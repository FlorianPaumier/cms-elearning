<?php


namespace App\Entity;


use App\Core\Interfaces\Entity;

class LessonChapter
{

    use Entity;

    /** @var Lesson
     */
    protected $lesson;

    /** @var string */
    protected $title;

    /** @var array */
    protected $blocks;

    /** @var int */
    protected $position;

    /**
     * @return int
     */
    public function getLesson(): ?Lesson
    {
        return $this->lesson;
    }

    /**
     * @param Lesson $lesson
     * @return LessonChapter
     */
    public function setLesson(Lesson $lesson): LessonChapter
    {
        $this->lessonId = $lesson;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return LessonChapter
     */
    public function setTitle(string $title): LessonChapter
    {
        $this->name = $title;
        return $this;
    }

    /**
     * @return array
     */
    public function getBlocks(): ?array
    {
        return $this->blocks;
    }

    /**
     * @param array $blocks
     * @return LessonChapter
     */
    public function setBlock(ChapterBlock $block): LessonChapter
    {
        $this->blocks = $block;
        return $this;
    }

    /**
     * @param array $blocks
     * @return LessonChapter
     */
    public function removeBlock(ChapterBlock $block): LessonChapter
    {
        $this->blocks = $this->removeElement($this->blocks, $block);
        return $this;
    }

    /**
     * @return int
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }

    /**
     * @param int $position
     * @return LessonChapter
     */
    public function setPosition(int $position): LessonChapter
    {
        $this->position = $position;
        return $this;
    }


}