<?php

namespace App\Entity;

use App\Core\Interfaces\Entity;
use PHPUnit\Exception;


class User
{
    use Entity;

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


    /** @return \DateTimeInterface|null
     * @throws Exception
     */
    protected $created_at;

    /**
     * @return \DateTimeInterface|null
     */
    protected $updated_at;


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
    public function setForgetPasswordToken(string $forgetPasswordToken): User
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

    /**
     * @return DateTimeInterface|null
     * @throws Exception
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param $created_at
     * @return $this
     */
    public function setCreatedAt($created_at): User
    {
        $this->created_at = date("Y-m-d H:i:s");

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param DateTimeInterface $updated_at
     * @return $this
     */
    public function setUpdatedAt($updated_at): User
    {
        $this->updated_at = date("Y-m-d H:i:s");

        return $this;
    }

    /**
     * PrePersist()
     * PreUpdate()
     */
    public function updateTimestamps(): void
    {
        $now = date("Y-m-d H:i:s");
        $this->setUpdatedAt($now);
        if ($this->getId() === null) {
            $this->setCreatedAt($now);
        }
    }
}