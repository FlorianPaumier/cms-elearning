<?php


namespace App\Entity;

use App\Core\Interfaces\Entity;

class ChatSession
{
    use Entity;

    protected $user;

    protected $sessionToken;

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getSession(): string
    {
        return $this->sessionToken;
    }

    /**
     * @param string $sessionToken
     */
    public function setSession(string $sessionToken): void
    {
        $this->session = $sessionToken;
    }

}