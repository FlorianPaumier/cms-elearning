<?php


namespace App\Core\Helpers;


abstract class EntityHelper
{

    public static function getClass(object $class): string
    {
        $classTab = explode("\\", get_class($class));
        $class = array_pop($classTab);
        return strtolower(StringTransformer::PascalCaseToSnakeCase($class));
    }

    public static function getEntity(string $class): object
    {
        $entity = StringTransformer::toPascalCase($class);

        if(class_exists($entity))
            return new $entity;

        throw new \Exception("No Entity $entity found");

    }

}