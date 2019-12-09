<?php


namespace App\Core\Request;


class ParameterBag
{

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function get($key): ?string
    {
        return key_exists($key ,$this->data) ? $this->data[$key] : null;
    }

    public function all(){
        return $this->data;
    }
}