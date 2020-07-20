<?php


namespace App\Core\Helpers;


trait TimestampableEntity
{

    /** @var \DateTime */
    protected $created_at;

    /** @var \DateTime */
    protected $updated_at;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updated_at;
    }

    /**
     * @param \DateTime $updated_at
     * @return TimestampableEntity
     */
    public function update(): TimestampableEntity
    {
        $this->updated_at = new \DateTime();
        return $this;
    }

}