<?php


namespace App\Core\Helpers;


abstract class EntityHelper
{

    public static function getClass(object $class): string
    {
        return strtolower(StringTransformer::PascalCaseToSnakeCase(self::getClassName(get_class($class))));
    }

    public static function getClassName(string $class): string
    {
        $classTab = explode("\\", $class);
        return array_pop($classTab);
    }

    public static function getEntity(string $class): object
    {
        $entity = StringTransformer::toPascalCase($class);

        if(class_exists($entity))
            return new $entity;

        throw new \Exception("No Entity $entity found");

    }

    public static function getProperties(object $object): ?array {

        $reflection = new \ReflectionClass($object);

        dump($reflection->getProperties());

        return [];
    }
}