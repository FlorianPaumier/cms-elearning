<?php


namespace App\Core\helpers;


class ArrayCollection
{
    private $collection;

    public function contain($data){
        return in_array($data, $this->collection);
    }

    public function add($data)
    {
        $this->collection[] = $data;
    }

    public function remove($data)
    {
        foreach ($this->collection as $key => $item){
            if($data === $item){
                unset($this->collection[$key]);
            }
        }
    }
}