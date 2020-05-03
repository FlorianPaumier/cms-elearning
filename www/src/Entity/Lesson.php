<?php


namespace App\Entity;


use App\Core\Helpers\ArrayCollection;
use App\Core\Interfaces\Entity;

class Lesson
{

    use Entity;

    /**
     * @var
     */
    protected $idAuthor;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var array
     */
    protected $chapters;

    public function __construct(int $id = null)
    {
        $this->chapters = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getIdAuthor(): ?int
    {
        return $this->idAuthor;
    }

    /**
     * @param mixed $idAuthor
     * @return Lesson
     */
    public function setIdAuthor($idAuthor)
    {
        $this->idAuthor = $idAuthor;
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
     * @return Lesson
     */
    public function setTitle(string $title): Lesson
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Lesson
     */
    public function setDescription(string $description): Lesson
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return array
     */
    public function getChapters(): ?ArrayCollection
    {
        return $this->chapters;
    }

    /**
     * @param array $chapters
     * @return Lesson
     */
    public function addChapters(LessonChapter $chapters): Lesson
    {
        if (!$this->chapters->contain($chapters)) {
            $this->chapters->add($chapters);
        }
        return $this;
    }

    /**
     * @param LessonChapter $chapter
     * @return Lesson
     * TODO : Implémenter un ArrayCollection
     */
    public function removeChapters(LessonChapter $chapter): Lesson
    {
        if ($this->chapters->contain($chapter)) {
            $this->chapters->removeElement($chapter);
        }
        return $this;
    }
}