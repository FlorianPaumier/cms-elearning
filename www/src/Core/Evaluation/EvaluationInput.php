<?php


namespace App\Core\Evaluation;


use App\Core\Interfaces\Entity;
use App\Core\Interfaces\GenerateFormInputInterface;
use App\Core\Interfaces\GenerateFormInterface;

class EvaluationInput implements GenerateFormInputInterface
{

    use Entity;

    /** @var string */
    private $formKey;

    /** @var string */
    private $label;

    /** @var string */
    private $type;

    /** @var bool */
    private $required;

    /** @var string */
    private $placeholder;

    /** @var array|null */
    private $choices;

    /** @var int */
    private $position;

    /** @var Evaluation */
    private $evaluation;

    /**
     * @return string
     */
    public function getFormKey(): ?string
    {
        return $this->formKey;
    }

    /**
     * @param string $formKey
     * @return EvaluationInput
     */
    public function setFormKey(string $formKey): GenerateFormInputInterface
    {
        $this->formKey = $formKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return EvaluationInput
     */
    public function setLabel(string $label): GenerateFormInputInterface
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return EvaluationInput
     */
    public function setType(string $type): GenerateFormInputInterface
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRequired(): ?bool
    {
        return $this->required;
    }

    /**
     * @param bool $required
     * @return EvaluationInput
     */
    public function setRequired(bool $required): GenerateFormInputInterface
    {
        $this->required = $required;
        return $this;
    }

    /**
     * @return string
     */
    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    /**
     * @param string $placeholder
     * @return EvaluationInput
     */
    public function setPlaceholder(string $placeholder): GenerateFormInputInterface
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    /**
     * @return array
     */
    public function getChoices(): ?array
    {
        return $this->choices;
    }

    /**
     * @param array $choices
     * @return EvaluationInput
     */
    public function setChoices(?array $choices): GenerateFormInputInterface
    {
        $this->choices = $choices;
        return $this;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param int $position
     * @return EvaluationInput
     */
    public function setPosition(int $position): GenerateFormInputInterface
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @return Evaluation
     */
    public function getEvaluation(): GenerateFormInterface
    {
        return $this->evaluation;
    }

    /**
     * @param EvaluationInput $evaluation
     * @return EvaluationInput
     */
    public function setEvaluation(Evaluation $evaluation): GenerateFormInputInterface
    {
        $this->evaluation = $evaluation;
        return $this;
    }
}