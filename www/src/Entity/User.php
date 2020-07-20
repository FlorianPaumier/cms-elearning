<?php

namespace App\Entity;

use App\Core\Helpers\TimestampableEntity;
use App\Core\Interfaces\Entity;

class User
{
    use Entity;
    use TimestampableEntity;

    protected $username;
    protected $password;
    protected $email;
    protected $status;

    /** @var string|null */
    protected $avatar;

    /** @var string|null */
    protected $lastname;

    /** @var string|null */
    protected $firstname;

    /** @var \DateTime|null */
    protected $age;

    /** @var string|null */
    protected $description;

    /** @var string|null */
    protected $forgetPasswordToken;

    /** @var \DateTime|null */
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
    public function getForgetPasswordToken(): ?string
    {
        return $this->forgetPasswordToken;
    }

    /**
     * @param string $forgetPasswordToken
     */
    public function setForgetPasswordToken( string $forgetPasswordToken): User
    {
        $this->forgetPasswordToken = $forgetPasswordToken;
        $this->setForgetPasswordTokenAvailable();
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getForgetPasswordTokenAvailable(): ?\DateTime
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
     * @return string
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * @param string $avatar
     * @return User
     */
    public function setAvatar(string $avatar): User
    {
        $this->avatar = $avatar;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return User
     */
    public function setDescription(string $description): User
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string|null $lastname
     * @return User
     */
    public function setLastname(?string $lastname): User
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string|null $firstname
     * @return User
     */
    public function setFirstname(?string $firstname): User
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getAge(): ?\DateTime
    {
        return $this->age;
    }

    /**
     * @param \DateTime|null $age
     * @return User
     */
    public function setAge(?\DateTime $age): User
    {
        $this->age = $age;
        return $this;
    }
}