<?php


namespace App\Entity;

use App\Core\Interfaces\Entity;

class ChatSession
{
    use Entity;

    protected $id;

    protected $idUser;

    protected $idSession;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

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
    public function setIdUser($idUser): void
    {
        $this->idUser = $idUser;
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