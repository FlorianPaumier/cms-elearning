<?php


namespace App\Entity;

use App\Core\Interfaces\Entity;

class ChatSession
{
    use Entity;

    protected $user;

    protected $tokenSession;

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
    public function getTokenSession(): string
    {
        return $this->tokenSession;
    }

    /**
     * @param string $tokenSession
     */
    public function setTokenSession(string $tokenSession): void
    {
        $this->tokenSession = $tokenSession;
    }

}