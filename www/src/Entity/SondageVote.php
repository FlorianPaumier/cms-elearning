<?php


namespace App\Entity;


use App\Core\Helpers\TimestampableEntity;
use App\Core\Interfaces\Entity;

class SondageVote
{

    use Entity;
//    use TimestampableEntity;

    /** @var string */
    protected $idVote;

    /** @var string */
    protected $choix;

    public function __construct(){}

    /**
     * @return int
     */
    public function getIdVote(): ?int
    {
        return $this->idVote;
    }

    /**
     * @param int $idVote
     * @return SondageVote
     */
    public function setIdVote(int $idVote): SondageVote
    {
        $this->idVote = $idVote;
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
}