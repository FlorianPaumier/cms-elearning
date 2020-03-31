<?php


namespace App\Core\Request;


class ParameterBag
{
    /** @var array */
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Return the data in the request if the key exist
     * @param $key
     * @return string|null
     */
    public function get($key): ?string
    {
        return key_exists($key, $this->data) ? $this->data[$key] : null;
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->data;
    }
}