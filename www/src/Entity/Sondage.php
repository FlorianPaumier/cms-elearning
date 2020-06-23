<?php


namespace App\Entity;


use App\Core\Interfaces\Entity;

class Sondage
{

    use Entity;

    /** @var int */
    protected $id;

    /** @var string */
    protected $question;

    /** @var \DateTime */
    protected $dateCreated;

    public function __construct(){
        $this->dateCreated = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Sondage
     */
    public function setId(int $id): Sondage
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getQuestion(): ?string
    {
        return $this->question;
    }

    /**
     * @param string $question
     * @return Sondage
     */
    public function setQuestion(string $question): Sondage
    {
        $this->question = $question;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreated(): ?\DateTime
    {
        return $this->dateCreated;
    }

    /**
     * @param \DateTime $dateCreated
     * @return Sondage
     */
    public function setDateCreated(\DateTime $dateCreated): Sondage
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }
}