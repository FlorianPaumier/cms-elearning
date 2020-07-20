<?php


namespace App\Core\Contact;


use App\Core\Interfaces\Entity;
use App\Core\Interfaces\GenerateFormInputInterface;
use App\Core\Interfaces\GenerateFormInterface;

class ContactInput implements GenerateFormInputInterface
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

    /** @var ContactForm */
    private $contactForm;

    /**
     * @return string
     */
    public function getFormKey(): ?string
    {
        return $this->formKey;
    }

    /**
     * @param string $formKey
     * @return ContactInput
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
     * @return ContactInput
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
     * @return ContactInput
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
     * @return ContactInput
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
     * @return ContactInput
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
     * @return ContactInput
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
     * @return ContactInput
     */
    public function setPosition(int $position): GenerateFormInputInterface
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @return ContactForm
     */
    public function getContactForm(): GenerateFormInterface
    {
        return $this->contactForm;
    }

    /**
     * @param ContactForm $contactForm
     * @return ContactInput
     */
    public function setContactForm(ContactForm $contactForm): GenerateFormInputInterface
    {
        $this->contactForm = $contactForm;
        return $this;
    }

}