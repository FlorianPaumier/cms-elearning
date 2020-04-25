<?php

namespace App\Entity;

use App\Core\Interfaces\Entity;

class User
{
    use Entity;

    protected $username;
    protected $password;
    protected $email;

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

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(User $email): void
    {
        $this->email = $email;
    }

}
