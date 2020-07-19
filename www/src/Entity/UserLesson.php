<?php


namespace App\Entity;


use App\Core\Helpers\TimestampableEntity;
use App\Core\Interfaces\Entity;

class UserLesson
{

    use Entity;
    use TimestampableEntity;

    /** @var User */
    protected $user;

    /** @var Lesson */
    protected $lesson;

    /** @var integer */
    protected $chapter;

    /** @var integer */
    protected $isOver;

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return UserLesson
     */
    public function setUser(User $user): UserLesson
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return Lesson
     */
    public function getLesson(): Lesson
    {
        return $this->lesson;
    }

    /**
     * @param Lesson $lesson
     * @return UserLesson
     */
    public function setLesson(Lesson $lesson): UserLesson
    {
        $this->lesson = $lesson;
        return $this;
    }

    /**
     * @return int
     */
    public function getChapter(): ?int
    {
        return $this->chapter;
    }

    /**
     * @param int $chapter
     * @return UserLesson
     */
    public function setChapter(int $chapter): UserLesson
    {
        $this->chapter = $chapter;
        return $this;
    }

    /**
     * @return int
     */
    public function getIsOver(): ?int
    {
        return $this->isOver;
    }

    /**
     * @param int $isOver
     * @return UserLesson
     */
    public function setIsOver(int $isOver): UserLesson
    {
        $this->isOver = $isOver;
        return $this;
    }

}