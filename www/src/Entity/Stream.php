<?php


namespace App\Entity;


use App\Core\Collections\ArrayCollection;
use App\Core\Helpers\TimestampableEntity;
use App\Core\Interfaces\Entity;

class Stream
{

    use Entity;
    use TimestampableEntity;

    /** @var string */
    protected $identifiant;

    /** @var \DateTime */
    protected $startAt;

    /** @var Event */
    protected $event;

    /** @var StreamInscription */
    protected $streamInscription;

    public function __construct()
    {
        $this->streamInscription = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getIdentifiant(): ?string
    {
        return $this->identifiant;
    }

    /**
     * @param string $identifiant
     * @return Stream
     */
    public function setIdentifiant(string $identifiant): Stream
    {
        $this->identifiant = $identifiant;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartAt(): ?\DateTime
    {
        return $this->startAt;
    }

    /**
     * @param \DateTime $startAt
     * @return Stream
     */
    public function setStartAt(\DateTime $startAt): Stream
    {
        $this->startAt = $startAt;
        return $this;
    }

    /**
     * @return Event
     */
    public function getEvent(): ?Event
    {
        return $this->event;
    }

    /**
     * @param Event $event
     * @return Stream
     */
    public function setEvent(Event $event): Stream
    {
        $this->event = $event;
        return $this;
    }

    /**
     * @return StreamInscription
     */
    public function getStreamInscription(): ?ArrayCollection
    {
        return $this->streamInscription;
    }

    /**
     * @param StreamInscription $inscription
     * @return Stream
     */
    public function addStreamInscription(StreamInscription $inscription): Stream
    {
        $this->streamInscription = $inscription;
        return $this;
    }
}