<?php


namespace App\Entity;


use App\Core\Helpers\TimestampableEntity;
use App\Core\Interfaces\Entity;

class StreamInscription
{

    use Entity;
    use TimestampableEntity;

    /** @var Stream */
    protected $stream;

    /** @var User */
    protected $user;

    /** @var boolean */
    protected $hadCame;
    /**
     * @return Stream
     */
    public function getStream(): Stream
    {
        return $this->stream;
    }

    /**
     * @param Stream $stream
     * @return StreamInscription
     */
    public function setStream(Stream $stream): StreamInscription
    {
        $this->stream = $stream;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return StreamInscription
     */
    public function setUser(User $user): StreamInscription
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return bool
     */
    public function isHadCame(): bool
    {
        return $this->hadCame;
    }

    /**
     * @param bool $hadCame
     * @return StreamInscription
     */
    public function setHadCame(bool $hadCame): StreamInscription
    {
        $this->hadCame = $hadCame;
        return $this;
    }
}