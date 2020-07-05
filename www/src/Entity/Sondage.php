<?php


namespace App\Entity;


use App\Core\Helpers\TimestampableEntity;
use App\Core\Interfaces\Entity;

class Sondage
{

    use Entity;
    use TimestampableEntity;

    /** @var string */
    protected $question;

    /** @var string */
    protected $optionOne;

    /** @var string */
    protected $optionTwo;

    /** @var string */
    protected $optionThree;

    /** @var string */
    protected $optionFour;

    public function __construct(){
        $this->optionThree = "";
        $this->optionFour = "";
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
     * @return string
     */
    public function getOptionOne(): ?string
    {
        return $this->optionOne;
    }

    /**
     * @param string $optionOne
     * @return Sondage
     */
    public function setOptionOne(string $optionOne): Sondage
    {
        $this->optionOne = $optionOne;
        return $this;
    }

    /**
     * @return string
     */
    public function getOptionTwo(): ?string
    {
        return $this->optionTwo;
    }

    /**
     * @param string $optionTwo
     * @return Sondage
     */
    public function setOptionTwo(string $optionTwo): Sondage
    {
        $this->optionTwo = $optionTwo;
        return $this;
    }

    /**
     * @return string
     */
    public function getOptionThree(): ?string
    {
        return $this->optionThree;
    }

    /**
     * @param string $optionThree
     * @return Sondage
     */
    public function setOptionThree(string $optionThree): Sondage
    {
        $this->optionThree = $optionThree;
        return $this;
    }

    /**
     * @return string
     */
    public function getOptionFour(): ?string
    {
        return $this->optionFour;
    }

    /**
     * @param string $optionFour
     * @return Sondage
     */
    public function setOptionFour(string $optionFour): Sondage
    {
        $this->optionFour = $optionFour;
        return $this;
    }
}