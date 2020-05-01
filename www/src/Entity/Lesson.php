<?php


namespace App\Entity;


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
    public function getChapters(): ?array
    {
        return $this->chapters;
    }

    /**
     * @param array $chapters
     * @return Lesson
     */
    public function addChapter(Chapter $chapters): Lesson
    {
        $this->chapters[] = $chapters;
        return $this;
    }

    /**
     * @param Chapter $chapter
     * @return Lesson
     * TODO : Implémenter un ArrayCollection
     */
    public function removeChapter(Chapter $chapter): Lesson
    {
        $this->chapters = $this->removeElement($this->chapters, $chapter);
        return $this;
    }
}