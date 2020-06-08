<?php

namespace App\Entity;

use App\Core\Interfaces\Entity;

class User
{
    use Entity;

    /**
     * @var $username
     */
    protected $username;
    /**
     * @var $password
     */
    protected $password;
    /**
     * @var $email
     */
    protected $email;
    /**
     * @var $lessons
     */
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
    public function setUsername($username): User
    {
        $this->username = $username;
        return $this;
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
    public function setPassword($password): User
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @param Lesson $lessons
     * @return $this
     */
    public function setLesson(Lesson $lessons)
    {
        $this->lessons[] = $lessons;
        return $this;
    }

}
