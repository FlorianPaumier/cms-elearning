<?php

namespace App\Core\database;

/**
 * Transforme un tableau en objet en utilisant les setters
 */
class Hydrator
{
    /**
     * Transforme un tableau en objet en utilisant les setters
     *
     * @param  array  $array
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
                $instance->$method($value);
            }
            $i++;
        }

        return $instance;
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
        return join('', array_map('ucfirst', explode('_', $fieldName)));
    }
}
