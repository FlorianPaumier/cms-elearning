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
        $json = [];

        if(empty($this->data) || is_null($this->data)) return json_encode("");

        foreach ($this->data as $key => $value){
            if (gettype($value) == "object"){
                $array = Hydrator::getData($value);
            }else{
                $array = $value;
            }

            $json[$key] = $array;
        }

        return json_encode($json,  true);
    }

    public function deserialize(string $class = null)
    {
        if(!is_null($class) && !class_exists($class)){
            throw new ClassNotFoundException();
        }
        $array = json_decode($this->data, true);

        if(is_null($class)){
            return $array;
        }

        $object = new $class();
        return Hydrator::hydrate($array, $object);
    }
}