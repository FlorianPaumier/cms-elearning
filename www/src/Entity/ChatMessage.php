<?php


namespace App\Entity;


use App\Core\Interfaces\Entity;

class ChatMessage
{
    use Entity;

    protected $id;

    protected $idUser;

    protected $message;

    protected $messageDate;

    protected $idSession;

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param mixed $idUser
     */
    public function setIdUser(int $idUser): void
    {
        $this->idUser = $idUser;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getMessageDate()
    {
        return $this->messageDate;
    }

    /**
     * @param mixed $messageDate
     */
    public function setMessageDate($messageDate): void
    {
        $this->messageDate = $messageDate;
    }

    /**
     * @return mixed
     */
    public function getIdSession()
    {
        return $this->idSession;
    }

    /**
     * @param mixed $idSession
     */
    public function setIdSession($idSession): void
    {
        $this->idSession = $idSession;
    }



}