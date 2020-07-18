<?php


namespace App\Entity;


use App\Core\Helpers\TimestampableEntity;
use App\Core\Interfaces\Entity;

class Newsletter
{

    use Entity;
    use TimestampableEntity;

    /** @var string */
    protected $title;

    /** @var string */
    protected $content;

    /** @var boolean */
    protected $sended;

    protected $id_user;

    public function __construct()
    {
        $this->id_user = 1;
    }

    /**
     * @return null|int
     */
    public function getIdUser(): ?int
    {
        return $this->id_user;
    }

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param null|string $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return null|string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param null|string $content
     */
    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return null|bool
     */
    public function isSended(): ?bool
    {
        return $this->sended;
    }

    /**
     * @param null|bool $sended
     */
    public function setSended(?bool $sended): void
    {
        $this->sended = $sended;
    }
}