<?php


namespace App\Entity;

use App\Core\Interfaces\Entity;

class Faq
{

    use Entity;

    /**
     * @var string
     */
    protected $question;

    /**
     * @var string
     */
    protected $reponse;

    public function __construct(int $id = null){}

    /**
     * @return string
     */
    public function getQuestion(): ?string
    {
        return $this->question;
    }

    /**
     * @param string $question
     * @return Lesson
     */
    public function setQuestion(string $question): Faq
    {
        $this->question = $question;
        return $this;
    }

    /**
     * @return string
     */
    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    /**
     * @param string $reponse
     * @return Faq
     */
    public function setReponse(string $reponse): Faq
    {
        $this->reponse = $reponse;
        return $this;
    }
}