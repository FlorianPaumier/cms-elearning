<?php


namespace App\Entity;


use App\Core\Collections\ArrayCollection;
use App\Core\Helpers\TimestampableEntity;
use App\Core\Interfaces\Entity;

class LessonChapter
{

    use Entity;
    use TimestampableEntity;

    /** @var Lesson
     */
    protected $lesson;

    /** @var string */
    protected $title;

    /** @var string */
    protected $content;

    /** @var int */
    protected $position;

    /**
     * @return Lesson|null
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
        $this->lesson = $lesson;
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
        $this->title = $title;
        return $this;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getBlocks(): ?ArrayCollection
    {
        return $this->blocks;
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
     * @return LessonChapter
     */
    public function setContent(string $content): LessonChapter
    {
        $this->content = $content;
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