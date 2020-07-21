<?php


namespace App\Entity;


use App\Core\Interfaces\Entity;

class SiteConfiguration
{

    use Entity;

    /** @var array|null */
    private $contact;

    protected $value;
    protected $key;

    /**
     * @return array|null
     */
    public function getContact(): ?array
    {
        return $this->contact;
    }

    /**
     * @param array|null $contact
     * @return SiteConfiguration
     */
    public function setContact(array $contact): SiteConfiguration
    {
        $this->contact = $contact;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return SiteConfiguration
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param mixed $key
     * @return SiteConfiguration
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }


}