<?php


namespace App\Core\Contact;


use App\Core\Interfaces\Entity;

class ContactMeta
{
    use Entity;

    /** @var ContactInput */
    private $input;

    /** @var string */
    private $value;

    /** @var EvaluationObject */
    private $contact;

    /**
     * @return string
     */
    public function getInput(): ?ContactInput
    {
        return $this->input;
    }

    /**
     * @param string $input
     * @return ContactMeta
     */
    public function setInput(ContactInput $input): ContactMeta
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
     * @return ContactMeta
     */
    public function setValue(string $value): ContactMeta
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
     * @return ContactMeta
     */
    public function setContact(EvaluationObject $contact): ContactMeta
    {
        $this->contact = $contact;
        return $this;
    }


}