<?php


namespace App\Core\Evaluation;


use App\Core\Interfaces\Entity;

class EvaluationMeta
{
    use Entity;

    /** @var EvaluationInput */
    private $input;

    /** @var string */
    private $value;

    /** @var EvaluationObject */
    private $contact;

    /**
     * @return string
     */
    public function getInput(): ?EvaluationInput
    {
        return $this->input;
    }

    /**
     * @param string $input
     * @return EvaluationMeta
     */
    public function setInput(EvaluationInput $input): self
    {
        $this->input = $input;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return EvaluationMeta
     */
    public function setValue(string $value): self
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return EvaluationObject
     */
    public function getContact(): ?EvaluationObject
    {
        return $this->contact;
    }

    /**
     * @param EvaluationObject $contact
     * @return EvaluationMeta
     */
    public function setContact(EvaluationObject $contact): self
    {
        $this->contact = $contact;
        return $this;
    }

}