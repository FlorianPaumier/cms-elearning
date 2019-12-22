<?php
namespace App\Core\Formatter;

use App\Core\database\Hydrator;
use Prophecy\Exception\Doubler\ClassNotFoundException;

class IniFormatter implements FormatterInterface
{

    private $data;

    public function setData($data)
    {
        $this->data = $data;
    }

    public function serialize()
    {
        return $this->toIni($this->data);
    }

    public function deserialize(string $class = null)
    {
        if(!is_null($class) && !class_exists($class)){
            throw new ClassNotFoundException();
        }

        $array = parse_ini_string($this->data);

        if(is_null($class)){
            return $array;
        }

        $object = new $class();
        return Hydrator::hydrate($array, $object);
    }

    private function toIni(array $data){
        return implode("\n", array_map(function ($key, $value){
            return $key."=".$value;
        }, array_keys($data), $data));
    }
}