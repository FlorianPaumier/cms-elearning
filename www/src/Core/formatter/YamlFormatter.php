<?php
namespace App\Core\Formatter;

use App\Core\database\Hydrator;
use Prophecy\Exception\Doubler\ClassNotFoundException;

class YamlFormatter implements FormatterInterface
{
    private $data;

    public function setData($data)
    {
        $this->data = $data;
    }

    public function serialize()
    {
        return yaml_emit($this->data);
    }

    public function deserialize(string $class)
    {
        if(!class_exists($class)){
            throw new ClassNotFoundException();
        }
        $array = yaml_parse($this->data);
        $object = new $class();
        return Hydrator::hydrate($array, $object);
    }
}