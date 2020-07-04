<?php


namespace App\Entity;


use App\Core\Collections\ArrayCollection;
use App\Core\Helpers\TimestampableEntity;
use App\Core\Interfaces\Entity;

class Lesson
{

    use Entity;
    use TimestampableEntity;

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

    protected $slug;

    protected $thumbnail;

    protected $user;

    protected $content;

    public function __construct(int $id = null)
    {
        $this->chapters = new ArrayCollection();
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
        if (!$this->chapters->contains($chapters)) {
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
        if ($this->chapters->contains($chapter)) {
            $this->chapters->removeElement($chapter);
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     * @return Lesson
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * @param mixed $thumbnail
     * @return Lesson
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return Lesson
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     * @return Lesson
     */
    public function setContent(string $content)
    {
        $this->content = $content;
        return $this;
    }
}