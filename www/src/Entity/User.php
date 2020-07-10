<?php

namespace App\Entity;

use App\Core\Helpers\TimestampableEntity;
use App\Core\Interfaces\Entity;
use phpDocumentor\Reflection\Types\This;

class User
{
    use Entity;
    use TimestampableEntity;

    protected $username;
    protected $password;
    protected $email;
    protected $id;
    protected $status;

    /** @var string */
    protected $forgetPasswordToken;

    /** @var \DateTime */
    protected $forgetPasswordTokenAvailable;

    protected $roles = ["ROLE_USER"];


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

    public function setEmail($email): self
    {
        $this->email = $email;
        return $this;
    }


    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }


    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($token): void
    {
        $this->status = $token;
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param string[] $roles
     * @return User
     */
    public function setRoles(array $roles): User
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @return string
     */
    public function getForgetPasswordToken()
    {
        return $this->forgetPasswordToken;
    }

    /**
     * @param string $forgetPasswordToken
     */
    public function setForgetPasswordToken(?string $forgetPasswordToken): User
    {
        $this->forgetPasswordToken = $forgetPasswordToken;
        $this->setForgetPasswordTokenAvailable();
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getForgetPasswordTokenAvailable()
    {
        return $this->forgetPasswordTokenAvailable;
    }

    /**
     * @return User
     */
    private function setForgetPasswordTokenAvailable(): User
    {
        $this->forgetPasswordTokenAvailable = new \DateTime("+ 5 minutes");
        return $this;
    }
}