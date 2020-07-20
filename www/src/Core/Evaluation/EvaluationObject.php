<?php


namespace App\Core\Evaluation;


use App\Core\Collections\ArrayCollection;
use App\Core\Form\FormBuilder;
use App\Core\Helpers\TimestampableEntity;
use App\Core\Interfaces\Entity;
use App\Entity\User;

class EvaluationObject
{
    use Entity;
    use TimestampableEntity;

    /** @var string */
    private $name;

    /** @var bool */
    private $enabled;
    /**
     * @var Evaluation
     */
    private $evaluation;

    /** @var ArrayCollection */
    private $evaluationMeta;

    /** @var User */
    private $user;

    /** @var integer */
    private $rating;

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return EvaluationObject
     */
    public function setName(?string $name): EvaluationObject
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     * @return EvaluationObject
     */
    public function setEnabled(?bool $enabled): EvaluationObject
    {
        $this->enabled = $enabled;
        return $this;
    }

    public function setEvaluation(Evaluation $form)
    {
        $this->evaluation = $form;
        return $this;
    }

    /**
     * @return FormBuilder
     */
    public function getEvaluation(): ?Evaluation
    {
        return $this->evaluation;
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
     * @return EvaluationObject
     */
    public function setUser(User $user): EvaluationObject
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return int
     */
    public function getRating(): ?int
    {
        return $this->rating;
    }

    /**
     * @param int $rating
     * @return EvaluationObject
     */
    public function setRating(int $rating): EvaluationObject
    {
        $this->rating = $rating;
        return $this;
    }

    public function addEvaluationMeta(EvaluationMeta $evaluationMeta)
    {
        $this->evaluationMeta[] = $evaluationMeta;
    }

    public function getEvaluationMeta()
    {
        return $this->evaluationMeta;
    }
}