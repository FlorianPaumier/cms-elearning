<?php


namespace App\Entity;


use App\Core\Helpers\ArrayCollection;
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

    public function __construct()
    {
        $this->blocks = new ArrayCollection();
    }

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
     * @return array
     */
    public function getBlocks(): ?ArrayCollection
    {
        return $this->blocks;
    }

    /**
     * @param array $blocks
     * @return LessonChapter
     */
    public function addBlock(LessonChapterBlock $block): LessonChapter
    {
        if (!$this->blocks->contain($block)) {
            $this->blocks->add($block);
        }
        return $this;
    }

    /**
     * @param array $blocks
     * @return LessonChapter
     */
    public function removeBlock(LessonChapterBlock $block): LessonChapter
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