<?php


namespace App\Entity;


use App\Core\Helpers\TimestampableEntity;
use App\Core\Interfaces\Entity;

class ChatMessage
{
    use Entity;
    use TimestampableEntity;

    protected $user;

    protected $message;

    protected $chatSession;

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
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return ChatSession
     */
    /*public function getChatSession(): ChatSession
    {
        return $this->chatSession;
    }*/

    /**
     * @param ChatSession $chatSession
     */
    /*public function setChatSession(ChatSession $chatSession): void
    {
        $this->chatSession = $chatSession;
    }*



}