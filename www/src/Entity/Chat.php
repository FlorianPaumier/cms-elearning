<?php


namespace App\Entity;

use App\Core\Interfaces\Entity;

class Chat
{
    use Entity;

    /** @var int */
    protected $idUser;

    /** @var string */
    protected $message;

    /**
     * @return int
     */
    public function getIdUser(): int
    {
        return $this->idUser;
    }

    /**
     * @param int $idUser
     * @return Chat
     */
    public function setIdChapter(int $idUser): Chat
    {
        $this->idUser = $idUser;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Chat
     */
    public function setMessage(string $message): Chat
    {
        $this->message = $message;
        return $this;
    }
}