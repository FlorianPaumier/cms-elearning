<?php


namespace App\Core\Interfaces;

use App\Core\database\Hydrator;

Trait Entity
{
    private $id;


    protected function __construct()
    {
        $this->id = null;
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    public function getVariables()
    {
        return get_object_vars($this);
    }

    public function objectToSql()
    {
        $vars = [];
        foreach($this->getVariables() as $key => $value){
            if(is_array($value)) {
                $value = json_encode($value);
            }

            if(!is_null($value)) {
                $vars[$key] = $value;
            }
        };

        return $vars;
    }
}