<?php


namespace App\Entity;


use App\Core\Interfaces\Entity;

class ChatAnnonce
{
    use Entity;

    protected $content;

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

}