<?php


namespace App\Core\Helpers;


abstract class EntityHelper
{

    /**
     * Return the class from an object
     * @param object $class
     * @return string
     */
    public static function getClass(object $class): string
    {
        return strtolower(StringTransformer::PascalCaseToSnakeCase(self::getClassName(get_class($class))));
    }

    /**
     * Return the class name from the namespace class
     * @param string $class
     * @return string
     */
    public static function getClassName(string $class): string
    {
        $classTab = explode("\\", $class);
        return array_pop($classTab);
    }

    /**
     * Return an instance of the class if it exist
     * @param string $class
     * @return object
     * @throws \Exception
     */
    public static function getEntity(string $class): object
    {
        $entity = StringTransformer::toPascalCase($class);

        if(class_exists($entity))
            return new $entity;

        throw new \Exception("No Entity $entity found");

    }

    /**
     * @deprecated
     * @param object $object
     * @return array|null
     * @throws \ReflectionException
     */
    public static function getProperties(object $object): ?array {

        $reflection = new \ReflectionClass($object);

        return [];
    }
}