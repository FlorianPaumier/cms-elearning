<?php


namespace App\Entity;


use App\Core\Interfaces\Entity;

class Chapter
{

    use Entity;

    /** @var int
     * TODO : Implémenter la récupération de l'objet
     */
    protected $idLesson;

    /** @var string */
    protected $name;

    /** @var array */
    protected $blocks;

    /** @var int */
    protected $position;

    /**
     * @return int
     */
    public function getIdLesson(): int
    {
        return $this->idLesson;
    }

    /**
     * @param int $idLesson
     * @return Chapter
     */
    public function setIdLesson(int $idLesson): Chapter
    {
        $this->idLesson = $idLesson;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Chapter
     */
    public function setName(string $name): Chapter
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return array
     */
    public function getBlocks(): array
    {
        return $this->blocks;
    }

    /**
     * @param array $blocks
     * @return Chapter
     */
    public function setBlock(ChapterBlock $block): Chapter
    {
        $this->blocks = $block;
        return $this;
    }

    /**
     * @param array $blocks
     * @return Chapter
     */
    public function removeBlock(ChapterBlock $block): Chapter
    {
        $this->blocks = $this->removeElement($this->blocks, $block);
        return $this;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param int $position
     * @return Chapter
     */
    public function setPosition(int $position): Chapter
    {
        $this->position = $position;
        return $this;
    }


}