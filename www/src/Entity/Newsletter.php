<?php


namespace App\Entity;


use App\Core\Helpers\TimestampableEntity;
use App\Core\Interfaces\Entity;

class Newsletter
{

    use Entity;
    use TimestampableEntity;

    /** @var null|string $title */
    protected ?string $title;

    /** @var null|string $content */
    protected ?string $content;

    /** @var null|boolean $sended */
    protected ?bool $sended;

    /** @var null|User $user*/
    protected ?User $user;


    /**
     * @param User $user
     * @return void
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return null|User
     */
    public function getUser(): ?User
    {
        return $this->user;
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