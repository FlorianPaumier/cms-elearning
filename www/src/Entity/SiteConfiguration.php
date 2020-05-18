<?php


namespace App\Entity;


use App\Core\Interfaces\Entity;

class SiteConfiguration
{

    use Entity;

    /** @var array|null */
    private $contact;

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


}