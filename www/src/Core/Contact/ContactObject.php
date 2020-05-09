<?php


namespace App\Core\Contact;


use App\Core\Helpers\TimestampableEntity;
use App\Core\Interfaces\Entity;

class ContactObject
{
    use Entity;
    use TimestampableEntity;

    /** @var string */
    private $name;

    /** @var bool */
    private $enabled;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ContactObject
     */
    public function setName(string $name): ContactObject
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     * @return ContactObject
     */
    public function setEnabled(bool $enabled): ContactObject
    {
        $this->enabled = $enabled;
        return $this;
    }

}