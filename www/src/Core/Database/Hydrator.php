<?php

namespace App\Core\Database;

use App\Core\Cache\ConfigHandler;
use App\Core\Helpers\StringTransformer;

/**
 * Transforme un tableau en objet en utilisant les setters
 */
abstract class Hydrator
{
    static $recursif = false;

    /**
     * Transforme un tableau en objet en utilisant les setters
     *
     * @param array $array
     * @param  $object
     * @return mixed
     */
    public static function hydrate($array, $object)
    {
        if (is_string($object)) {
            $instance = new $object();
        } else {
            $instance = $object;
        }
        $i = 0;

        foreach ($array as $key => $value) {
            $method = self::getSetter($key);

            if (method_exists($instance, $method)) {
                $type = self::getParameterType($instance, $method);

                if (!is_null($type) && !self::isRecursif()) {
                    $class = $type->getName();

                    if (!($value instanceof $class)) {

                        if (gettype($value) == "integer") {
                            self::$recursif = true;
                            /** @var Table $repo */
                            $repo = ConfigHandler::get("repository");
                            $repo->getClass($class);
                            $value = $repo->find($value)[0];

                        }
                    }
                    self::$recursif = false;
                }

                if(self::isTypeArray($instance, $method)){
                    $value = json_decode($value);
                }

                $instance->$method($value);
            }
            $i++;
        }

        return $instance;
    }

    public static function getData(object $object): array
    {

        $params = [];

        $class = new \ReflectionClass(get_class($object));

        /** @var \ReflectionProperty $property */
        foreach ($class->getProperties() as $property) {
            $name = $property->getName();
            $method = "get" . StringTransformer::toPascalCase($name);
            if (!method_exists($object, $method)) {
                $method = "is" . ucfirst($name);
                if (!method_exists($object, $method)) {
                    ConfigHandler::get("eventEmmiter")->emit("erreur.404", "method don't exist for $name in " . get_class($object));
                }
            }

            $value = $object->$method();

            if (!is_null($value)) {
                if($value instanceof \DateTime){
                    $value = $value->format("d-m-Y h:i:s");
                }
                if(gettype($value) == "object"){
                    $value = $value->getId();
                }

                if(gettype($value) == "array"){
                    dump($value);
                    dump(gettype($value));
                    $value = json_encode($value);
                dump($value);
                }
                $params[$name] = $value;
            }
        };

        return $params;

    }

    /**
     * @return bool
     */
    public static function isRecursif(): bool
    {
        return self::$recursif;
    }

    private static function getParameterType(object $instance, string $method)
    {
        $reflection = new \ReflectionMethod($instance, $method);

        /** @var \ReflectionParameter $parameter */
        return $reflection->getParameters()[0]->getClass();
    }

    private static function isTypeArray(object $instance, string $method){
        $reflection = new \ReflectionMethod($instance, $method);
        return $reflection->getParameters()[0]->isArray();
    }
    /**
     * format function set
     * @param string $fieldName
     * @return string
     */
    private static function getSetter(string $fieldName): string
    {
        return 'set' . self::getProperty($fieldName);
    }

    /**
     * Format the field Name
     * @param string $fieldName
     * @return string
     */
    private static function getProperty(string $fieldName): string
    {
        $field = join('', array_map('ucfirst', explode('_', $fieldName)));

        if (preg_match('/_id/m', $fieldName)) {
            $field = str_replace("Id", "", $field);
        }

        return $field;
    }
}
