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
     * @return mixed
     */
    public function get($key)
    {
        if (preg_match("/\[\]/", $key)) {
            $key = preg_replace("/\[\]/", "", $key);
        }
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