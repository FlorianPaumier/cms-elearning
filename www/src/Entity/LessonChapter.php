<?php


namespace App\Entity;


use App\Core\Collections\ArrayCollection;
use App\Core\Interfaces\Entity;

class LessonChapter
{

    use Entity;

    /** @var Lesson
     */
    protected $lesson;

    /** @var string */
    protected $title;

    /** @var ArrayCollection */
    protected $lessonChapterBlocks;

    /** @var int */
    protected $position;

    public function __construct()
    {
        $this->lessonChapterBlocks = new ArrayCollection();
    }

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
     * @param LessonChapterBlock $block
     * @return LessonChapter
     */
    public function addLessonChapterBlock(LessonChapterBlock $block): LessonChapter
    {

        if (!$this->lessonChapterBlocks->contains($block)) {
            $this->lessonChapterBlocks[] = $block;
        }

        return $this;
    }

    /**
     * @param LessonChapterBlock $block
     * @return LessonChapter
     */
    public function removeBlock(LessonChapterBlock $block): LessonChapter
    {
        if ($this->lessonChapterBlocks->contains($block)) {
            $this->lessonChapterBlocks->removeElement($block);
        }
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