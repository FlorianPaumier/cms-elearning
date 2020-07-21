<?php


namespace App\Entity;


use App\Core\Helpers\TimestampableEntity;
use App\Core\Interfaces\Entity;

class Event
{

    use Entity;
    use TimestampableEntity;

    /** @var string */
    private $content;

    /** @var string */
    private $slug;

    /** @var string */
    private $title;

    /** @var \DateTime */
    private $publishAt;

    /** @var \DateTime */
    private $happenAt;

    /** @var Stream */
    protected $stream;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
        $this->publishAt = new \DateTime();
    }

    /**
     * @return string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Event
     */
    public function setContent(string $content): Event
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return Event
     */
    public function setSlug(string $slug): Event
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Event
     */
    public function setTitle(string $title): Event
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPublishAt(): ?\DateTime
    {
        return $this->publishAt;
    }

    /**
     * @param \DateTime $publishAt
     * @return Event
     */
    public function setPublishAt(\DateTime $publishAt): Event
    {
        $this->publishAt = $publishAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getHappenAt(): ?\DateTime
    {
        return $this->happenAt;
    }

    /**
     * @param \DateTime $happenAt
     * @return Event
     */
    public function setHappenAt(\DateTime $happenAt): Event
    {
        $this->happenAt = $happenAt;
        return $this;
    }

    /**
     * @return Stream
     */
    public function getStream(): ?Stream
    {
        return $this->stream;
    }

    /**
     * @param Stream $stream
     * @return Event
     */
    public function setStream(?Stream $stream): Event
    {
        $this->stream = $stream;
        return $this;
    }
}