<?php

namespace App\Entity;

use App\Core\Interfaces\Entity;

class User
{
    use Entity;

    protected $username;
    protected $password;
    protected $email;
    protected $lesson;

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

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function getLesson()
    {
        return $this->lesson;
    }

    public function setLesson($lesson): void
    {
        $this->lesson[] = $lesson;
    }

}
