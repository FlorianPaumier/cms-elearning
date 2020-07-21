<?php


namespace App\Core\Contact;


use App\Core\Helpers\TimestampableEntity;
use App\Core\Interfaces\Entity;
use App\Core\Interfaces\GenerateFormInterface;
use phpDocumentor\Reflection\Types\This;

class ContactForm implements GenerateFormInterface
{
    use Entity;
    use TimestampableEntity;

    /** @var string */
    private $name;

    /** @var string */
    private $path;

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
     * @return ContactForm
     */
    public function setName(string $name): ContactForm
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return ContactForm
     */
    public function setPath(string $path): ContactForm
    {
        $this->path = $path;
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
     * @return ContactForm
     */
    public function setEnabled(bool $enabled = false): ContactForm
    {
        $this->enabled = $enabled;
        return $this;
    }

}