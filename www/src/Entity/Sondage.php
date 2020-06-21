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
    protected $date_created;

    public function __construct(){}

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
    public function getDate(): ?\DateTime
    {
        return $this->date_created;
    }

    /**
     * @param \DateTime $date_created
     * @return Sondage
     */
    public function setDate(\DateTime $date_created): Sondage
    {
        $this->date_created = $date_created;
        return $this;
    }
}