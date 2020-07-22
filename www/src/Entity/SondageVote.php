<?php


namespace App\Entity;


use App\Core\Helpers\TimestampableEntity;
use App\Core\Interfaces\Entity;

class SondageVote
{

    use Entity;
//    use TimestampableEntity;

    /** @var Sondage */
    protected $sondage;

    /** @var string */
    protected $choix;

    /** @var User */
    protected $user;

    public function __construct(){}

    /**
     * @return Sondage
     */
    public function getSondage(): ?Sondage
    {
        return $this->sondage;
    }

    /**
     * @param int $sondage
     * @return SondageVote
     */
    public function setSondage(Sondage $sondage): SondageVote
    {
        $this->sondage = $sondage;
        return $this;
    }

    /**
     * @return int
     */
    public function getChoix(): ?int
    {
        return $this->choix;
    }

    /**
     * @param int $choix
     * @return SondageVote
     */
    public function setChoix(int $choix): SondageVote
    {
        $this->choix = $choix;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return SondageVote
     */
    public function setUser(User $user): SondageVote
    {
        $this->user = $user;
        return $this;
    }


}