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
    private $evaluationObject;

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
    public function getEvaluationObject(): ?EvaluationObject
    {
        return $this->evaluationObject;
    }

    /**
     * @param EvaluationObject $evaluationObject
     * @return EvaluationMeta
     */
    public function setEvaluationObject(EvaluationObject $evaluationObject): self
    {
        $this->evaluationObject = $evaluationObject;
        return $this;
    }

}