<?php


namespace App\Core\Interfaces;

use App\Core\database\Hydrator;
use App\Core\Database\Table;
use App\Core\Kernel\Kernel;

Trait Entity
{
    protected $id;

    public function __construct(int $id = null)
    {
        return $this->setId($id);
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id = null){
        $this->id = $id;

        if(is_null($id)){
            return $this;
        }

        /** @var Table $table */
        $table = Kernel::get('repository');
        $entityNamespace = explode("\\", get_class());
        $entityName = strtolower(array_pop($entityNamespace));
        return Hydrator::hydrate($table->from($entityName)->find($id), $this);
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