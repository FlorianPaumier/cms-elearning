<?php


namespace App\Entity;


use App\Core\Interfaces\Entity;

class Category
{

    use Entity;

    /** @var null|string $category*/
    protected $category;

    /**
     * @param string $category
     * @return void
     */
    public function setCategory(?string $category): void
    {
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }
}