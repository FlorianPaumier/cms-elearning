<?php
namespace App\Core\Formatter;

use App\Core\database\Hydrator;
use Prophecy\Exception\Doubler\ClassNotFoundException;

class JsonFormatter implements FormatterInterface
{
    private $data;

    public function setData($data)
    {
        $this->data = $data;
    }

    public function serialize()
    {
        return json_encode($this->data);
    }

    public function deserialize(string $class)
    {
        if(!class_exists($class)){
            throw new ClassNotFoundException();
        }
        $array = json_decode($this->data);
        $object = new $class();
        return Hydrator::hydrate($array, $object);
    }
}