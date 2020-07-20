<?php


namespace App\Core\Interfaces;

use App\Core\database\Hydrator;
use App\Core\Database\EntityManager;
use App\Core\Kernel\Kernel;

Trait Entity
{
    protected $id;

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
        return $this;
    }

    public function getEntity(int $id)
    {
        /** @var EntityManager $table */
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

    protected function removeElement(array $target, $needle): array
    {
        foreach ($target as $key => $value){
            if($value === $needle){
                $target = array_slice($target, $key, 1);
                break;
            }
        }

        return $target;
    }
}