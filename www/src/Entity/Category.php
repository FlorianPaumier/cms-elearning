<?php


namespace App\Entity;


use App\Core\Interfaces\Entity;

class Category
{

    use Entity;

    /** @var string */
    protected $category;

    /**
     * @param string $category
     * @return string
     */
    public function setCategory(string $category): string
    {
        $this->category = $category;

        return $this->category;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }
}