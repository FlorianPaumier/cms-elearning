<?php


namespace App\Core\Interfaces;


use App\Core\Contact\ContactForm;

interface GenerateFormInputInterface
{

    /**
     * @return string
     */
     function getFormKey(): ?string;

    /**
     * @param string $formKey
     * @return GenerateFormInputInterface
     */
     function setFormKey(string $formKey): self;

    /**
     * @return string
     */
     function getLabel(): ?string;

    /**
     * @param string $label
     * @return GenerateFormInputInterface
     */
     function setLabel(string $label): self;

    /**
     * @return string
     */
     function getType(): ?string;

    /**
     * @param string $type
     * @return self;
     */
     function setType(string $type): self;
    

    /**
     * @return bool
     */
     function isRequired(): ?bool;

    /**
     * @param bool $required
     * @return self;
     */
     function setRequired(bool $required): self;

    /**
     * @return string
     */
     function getPlaceholder(): ?string;

    /**
     * @param string $placeholder
     * @return self;
     */
     function setPlaceholder(string $placeholder): self;

    /**
     * @return array
     */
     function getChoices(): ?array;

    /**
     * @param array $choices
     * @return self;
     */
     function setChoices(?array $choices): self;

    /**
     * @return int
     */
     function getPosition(): int;

    /**
     * @param int $position
     * @return self;
     */
     function setPosition(int $position): self;

}