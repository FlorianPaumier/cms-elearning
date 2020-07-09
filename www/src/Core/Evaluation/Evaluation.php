<?php


namespace App\Core\Evaluation;


use App\Core\Helpers\TimestampableEntity;
use App\Core\Interfaces\Entity;
use App\Core\Interfaces\GenerateFormInterface;
use App\Entity\Lesson;

class Evaluation implements GenerateFormInterface
{
    use Entity;
    use TimestampableEntity;

    /** @var string */
    protected $name;

    /** @var string */
    protected $path;

    /** @var bool */
    protected $enabled;

    protected $description;

    /** @var Lesson */
    protected $lesson;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Evaluation
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return Evaluation
     */
    public function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     * @return Evaluation
     */
    public function setEnabled(bool $enabled = false): self
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Evaluation
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return Lesson
     */
    public function getLesson(): ?Lesson
    {
        return $this->lesson;
    }

    /**
     * @param Lesson $lesson
     * @return Evaluation
     */
    public function setLesson(Lesson $lesson): Evaluation
    {
        $this->lesson = $lesson;
        return $this;
    }
}

