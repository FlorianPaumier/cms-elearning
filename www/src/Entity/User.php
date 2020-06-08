<?php


namespace App\Entity;

use App\Core\Interfaces\Entity;

class User
{
    use Entity;

    protected $username;
    protected $password;
    protected $email;
    protected $lessons;

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword(User $password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getLessons()
    {
        return $this->lessons;
    }

    /**
     * @param Lesson $lesson
     */
    public function setLessons(Lesson $lesson): User
    {
        $this->lessons[] = $lesson;
        return $this;
    }

}